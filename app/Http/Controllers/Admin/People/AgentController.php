<?php

namespace App\Http\Controllers\Admin\People;

use App\Http\Controllers\Controller;
use App\Models\Admin\People\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AgentController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $agents = Agent::where('company_id', $user->company_id)->get();
        return view('backend.pages.people.agent', compact('agents'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $agents = Agent::with('branch')->where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($agents);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name'                => 'required|string|max:50',
                'last_name'                 => 'required|string|max:50',
                'phone_number'              => 'required|string|max:20',
                'email'                     => 'nullable|email|max:255',
                'opening_balance'           => 'nullable|string|max:255',
                'date_of_birth'             => 'required|date',
                'take_registration_fee'     => 'required|in:0,1',
                'registration_fee_amount'   => 'nullable|string|max:255',
                'branch_id'                 => 'required|exists:branches,id', 
                'country_id'                => 'required|exists:countries,id', 
                'division_id'               => 'required|exists:divisions,id', 
                'district_id'               => 'required|exists:districts,id', 
                'thana_id'                  => 'required|exists:thanas,id', 
                'employee_id'               => 'required|exists:employees,id',
                'agent_photo'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'passport_scan_copy'        => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'attachment'                => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'opening_balance_sheet'     => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'current_address'           => 'nullable|string|max:1000',
                'parmanent_address'         => 'nullable|string|max:1000',
                'note'                      => 'nullable|string|max:1000',
                'status'                    => 'nullable|boolean',
            ]);

            $user = Auth::user();
            $user_id = $user->id;

            // Get the company
            $company = $user->company;
            preg_match('/\d+/', $company->company_code, $matches);
            $companyNumber = $matches[0] ?? '000';
            // Generate next employee ID
            $lastEmployee = Agent::where('company_id', $company->id)
            ->where('agent_code', 'like', 'AGT' . $companyNumber . '%')
            ->orderByDesc('agent_code')
            ->first();
        
            if ($lastEmployee && preg_match('/AGT' . $companyNumber . '(\d+)/', $lastEmployee->agent_code, $codeMatch)) {
                $lastNumber = (int)$codeMatch[1];
            } else {
                $lastNumber = 0;
            }
            
            $nextNumber = $lastNumber + 1;
            $agentCode = 'AGT' . $companyNumber . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Handle file uploads
            $uploadFile = function ($fileField) use ($request) {
                if ($request->hasFile($fileField) && $request->file($fileField)->isValid()) {
                    $file = $request->file($fileField);
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    return $file->storeAs('uploads/agent', $filename, 'public');
                }
                return null;
            };

            $data = $request->only([
                'branch_id','first_name', 'last_name', 'phone_number', 'email',
                'opening_balance', 'date_of_birth', 'take_registration_fee', 'registration_fee_amount',
                'country_id', 'division_id', 'district_id', 'thana_id', 'employee_id',
                'current_address', 'parmanent_address', 'note', 'status'
            ]);

            // Set user ID
            $data['user_id'] = $user_id;
            $data['agent_code'] = $agentCode;
            $data['company_id'] = $user->company_id;

            // Set file paths
            $data['agent_photo']            = $uploadFile('agent_photo');
            $data['passport_scan_copy']     = $uploadFile('passport_scan_copy');
            $data['attachment']             = $uploadFile('attachment');
            $data['opening_balance_sheet']  = $uploadFile('opening_balance_sheet');

            // Store the record
            Agent::create($data);

            User::create([
                'company_id' => $user->company_id,
                'name'       => ($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? 'Unknown'),
                'username'   => $agentCode,
                'role'       => 'Agent',
                'email'      => $data['email'],
                'password'   => Hash::make('12345678'),
                'isActive'   => $data['status'] ?? 1,
            ]);

            return response()->json(['status' => 'success','message' => 'Agent added successfully']);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail','errors' => $e->validator->errors(),], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage(),], 500);
        }
    }



    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $agents = Agent::findOrFail($id);
        return response()->json($agents);
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'first_name'                => 'required|string|max:50',
                'last_name'                 => 'required|string|max:50',
                'phone_number'              => 'required|string|max:20',
                'email'                     => 'nullable|email|max:255',
                'opening_balance'           => 'nullable|string|max:255',
                'date_of_birth'             => 'required|date',
                'take_registration_fee'     => 'required|in:0,1',
                'registration_fee_amount'   => 'nullable|string|max:255',
                'branch_id'                 => 'required|exists:branches,id', 
                'country_id'                => 'required|exists:countries,id', 
                'division_id'               => 'required|exists:divisions,id', 
                'district_id'               => 'required|exists:districts,id', 
                'thana_id'                  => 'required|exists:thanas,id', 
                'employee_id'               => 'required|exists:employees,id',
                'agent_photo'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'passport_scan_copy'        => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'attachment'                => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'opening_balance_sheet'     => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'current_address'           => 'nullable|string|max:1000',
                'parmanent_address'         => 'nullable|string|max:1000',
                'note'                      => 'nullable|string|max:1000',
                'status'                    => 'nullable|boolean',
            ]);

            $agent = Agent::findOrFail($id);

            $user = Auth::user();
            $user_id = $user->id;

            // Handle file uploads
            $uploadFile = function ($fileField) use ($request) {
                if ($request->hasFile($fileField) && $request->file($fileField)->isValid()) {
                    $file = $request->file($fileField);
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    return $file->storeAs('uploads/agent', $filename, 'public');
                }
                return null;
            };

            $data = $request->only([
                'branch_id', 'first_name', 'last_name', 'phone_number', 'email',
                'opening_balance', 'date_of_birth', 'take_registration_fee', 'registration_fee_amount',
                'country_id', 'division_id', 'district_id', 'thana_id', 'employee_id',
                'current_address', 'parmanent_address', 'note', 'status'
            ]);

            // Set user ID
            $data['user_id'] = $user_id;
            $data['company_id'] = $user->company_id;

            // Update file paths if new files are uploaded
            if ($newFile = $uploadFile('agent_photo')) {
                $data['agent_photo'] = $newFile;
            }
            if ($newFile = $uploadFile('passport_scan_copy')) {
                $data['passport_scan_copy'] = $newFile;
            }
            if ($newFile = $uploadFile('attachment')) {
                $data['attachment'] = $newFile;
            }
            if ($newFile = $uploadFile('opening_balance_sheet')) {
                $data['opening_balance_sheet'] = $newFile;
            }

            $agent->update($data);

            if ($agent->user_id) {
                User::where('id', $agent->user_id)->update([
                    'isActive' => $request->status,
                ]);
            }
            return response()->json(['status' => 'success','message' => 'Agent updated successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail','errors' => $e->validator->errors(),], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage(),], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $agent = Agent::findOrFail($id);
            User::where('username', $agent->agent_code)->delete();
            $agent->delete();

            return response()->json(['status' => 'success', 'message' => 'employees deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
