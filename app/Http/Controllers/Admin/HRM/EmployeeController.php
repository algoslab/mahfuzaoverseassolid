<?php

namespace App\Http\Controllers\Admin\HRM;

use App\Http\Controllers\Controller;
use App\Models\Admin\HRM\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employees = Employee::where('user_id', $user->id)
                          ->where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.hrm.employee', compact('employees'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $employees = Employee::with('branch')->where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($employees);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'first_name'        => 'required|string|max:255',
                'last_name'         => 'required|string|max:255',
                'religion'          => 'nullable|string|max:255',
                'gender'            => 'nullable|string|max:255',
                'marital_status'    => 'nullable|string|max:255',
                'date_of_birth'     => 'required|date',
                'date_of_joining'   => 'required|date',
                'blood_group'       => 'nullable|string|max:10',
                'personal_phone'    => 'nullable|string|max:20',
                'personal_email'    => 'required|email|max:255',
                'contact_person_number' => 'nullable|string|max:20',
                'photo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'office_phone'      => 'nullable|string|max:20',
                'office_email'      => 'required|email|max:255',
                'nid_number'        => 'nullable|string|max:50',
                'current_address'   => 'nullable|string',
                'permanent_address' => 'nullable|string',
                'note'              => 'nullable|string',
                'branch_id'         => 'required|exists:branches,id', 
                'role_id'           => 'nullable|exists:roles,id',  
                'department_id'     => 'nullable|exists:departments,id',  
                'designation_id'    => 'nullable|exists:designations,id', 
                'roster_id'         => 'nullable|exists:rosters,id', 
                'basic_salary_monthly' => 'nullable|numeric',
                'basic_salary_daily' => 'nullable|numeric',
                'mobile_allowance'  => 'nullable|numeric',
                'salary_pay_method' => 'nullable|string|max:255',
                'contract_type'     => 'nullable|string|max:255',
                'access_card'       => 'nullable|string|max:255',
                'white_list'        => 'nullable|boolean',
                'weekend_day'       => 'nullable|string|max:10',
                'status'            => 'nullable|boolean',
            ]);

            // Handle photo upload if provided
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('employee_photos', 'public');
                $validatedData['photo'] = $photoPath;
            }
            $user = Auth::user();

            // Get the company
            $company = $user->company;
            preg_match('/\d+/', $company->company_code, $matches);
            $companyNumber = $matches[0] ?? '000'; // fallback to '000' if no number found
            // Generate next employee ID
            $lastEmployee = Employee::where('company_id', $company->id)
            ->where('employee_code', 'like', 'EMP' . $companyNumber . '%')
            ->orderByDesc('employee_code')
            ->first();
        
            if ($lastEmployee && preg_match('/EMP' . $companyNumber . '(\d+)/', $lastEmployee->employee_code, $codeMatch)) {
                $lastNumber = (int)$codeMatch[1];
            } else {
                $lastNumber = 0;
            }
            
            $nextNumber = $lastNumber + 1;
            $employeeCode = 'EMP' . $companyNumber . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);


            // Create new employee record
            $employee = Employee::create([
                'first_name'            => $validatedData['first_name'],
                'last_name'             => $validatedData['last_name'],
                'employee_code'         => $employeeCode,  // Use the generated employee code
                'religion'              => $validatedData['religion'] ?? null,
                'gender'                => $validatedData['gender'] ?? null,
                'marital_status'        => $validatedData['marital_status'] ?? null,
                'date_of_birth'         => $validatedData['date_of_birth'],
                'date_of_joining'       => $validatedData['date_of_joining'],
                'blood_group'           => $validatedData['blood_group'] ?? null,
                'personal_phone'        => $validatedData['personal_phone'] ?? null,
                'personal_email'        => $validatedData['personal_email'],
                'contact_person_number' => $validatedData['contact_person_number'] ?? null,
                'photo'                 => $validatedData['photo'] ?? null,
                'office_phone'          => $validatedData['office_phone'] ?? null,
                'office_email'          => $validatedData['office_email'],
                'nid_number'            => $validatedData['nid_number'] ?? null,
                'current_address'       => $validatedData['current_address'] ?? null,
                'permanent_address'     => $validatedData['permanent_address'] ?? null,
                'note'                  => $validatedData['note'] ?? null,
                'branch_id'             => $validatedData['branch_id'],
                'role_id'               => $validatedData['role_id'],  
                'department_id'         => $validatedData['department_id'],  
                'designation_id'        => $validatedData['designation_id'],  
                'roster_id'             => $validatedData['roster_id'],  
                'basic_salary_monthly'  => $validatedData['basic_salary_monthly'] ?? null,
                'basic_salary_daily'    => $validatedData['basic_salary_daily'] ?? null,
                'mobile_allowance'      => $validatedData['mobile_allowance'] ?? null,
                'salary_pay_method'     => $validatedData['salary_pay_method'] ?? null,
                'contract_type'         => $validatedData['contract_type'] ?? null,
                'access_card'           => $validatedData['access_card'] ?? null,
                'white_list'            => $validatedData['white_list'] ?? 0,
                'weekend_day'           => $validatedData['weekend_day'] ?? null,
                'status'                => $validatedData['status'] ?? 1, 
                'user_id'               => $user->id,
                'company_id'            => $user->company_id,
            ]);

            $user = User::create([
                'company_id' => $employee->company_id,
                'name'       => ($validatedData['first_name'] ?? '') . ' ' . ($validatedData['last_name'] ?? 'Unknown'),
                'username'   => $employeeCode,
                'role'       => $employee->role->name,
                'email'      => $validatedData['personal_email'],
                'password'   => Hash::make('12345678'),
                'isActive'   => $validatedData['status'] ?? 1,
            ]);

            // Return success response with employee code
            return response()->json(['status' => 'success', 'message' => 'Employee added successfully', 'employee_code' => $employeeCode]);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'errors' => $e->validator->errors()], 422); 
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }
    
    
    


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $employees = Employee::findOrFail($id);
        return response()->json($employees);
    }

    public function accessCard(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        if ($request->isMethod('get')) {
            return response()->json([
                'access_card'   => $employee->access_card,
                'full_name'   => $employee->first_name . ' ' . $employee->last_name,
            ]);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'access_card' => 'required|string',
            ]);

            $employee->access_card = $request->access_card;
            $employee->save();

            return response()->json(['message' => 'Access Card updated successfully.']);
        }
    }

    public function finger(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        if ($request->isMethod('get')) {
            return response()->json([
                'full_name'   => $employee->first_name . ' ' . $employee->last_name,
                'add_finger' => $employee->add_finger,
                'is_active_finger' => $employee->is_active_finger,
            ]);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'add_finger' => 'required|string',
                'is_active_finger' => 'required|boolean'
            ]);

            $employee->add_finger = $request->add_finger;
            $employee->is_active_finger = $request->is_active_finger ? 1 : 0;
            $employee->save();

            return response()->json(['message' => 'Fingerprint updated successfully.']);
        }
    }


    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'religion'              => 'nullable|string|max:255',
            'gender'                => 'nullable|string|max:255',
            'marital_status'        => 'nullable|string|max:255',
            'date_of_birth'         => 'required|date',
            'date_of_joining'       => 'required|date',
            'blood_group'           => 'nullable|string|max:10',
            'personal_phone'        => 'nullable|string|max:20',
            'personal_email'        => 'required|email|max:255',
            'contact_person_number' => 'nullable|string|max:20',
            'photo'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'office_phone'          => 'nullable|string|max:20',
            'office_email'          => 'required|email|max:255',
            'nid_number'            => 'nullable|string|max:50',
            'current_address'       => 'nullable|string',
            'permanent_address'     => 'nullable|string',
            'note'                  => 'nullable|string',
            'branch_id'             => 'required|exists:branches,id', 
            'role_id'               => 'nullable|exists:roles,id',  
            'department_id'         => 'nullable|exists:departments,id',  
            'designation_id'        => 'nullable|exists:designations,id', 
            'roster_id'             => 'nullable|exists:rosters,id', 
            'basic_salary_monthly' => 'nullable|numeric',
            'basic_salary_daily'   => 'nullable|numeric',
            'mobile_allowance'     => 'nullable|numeric',
            'salary_pay_method'    => 'nullable|string|max:255',
            'contract_type'        => 'nullable|string|max:255',
            'access_card'          => 'nullable|string|max:255',
            'white_list'           => 'nullable|boolean',
            'weekend_day'          => 'nullable|string|max:10',
            'status'               => 'nullable|boolean',
        ]);
    
        $user = Auth::user();
        $employee = Employee::findOrFail($id);
    
        // Handle file upload if exists
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employees', 'public');
            $validated['photo'] = $photoPath;
        }
    
        $validated['user_id'] = $user->id;
    
        // Full name (optional)
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
    
        $employee->update($validated);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Employee updated successfully',
        ]);
    }
    
    

    public function destroy(string $id)
    {
        try {
            $employees = Employee::findOrFail($id);
            User::where('username', $employees->employee_code)->delete();
            $employees->delete();

            return response()->json(['status' => 'success', 'message' => 'employees deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
