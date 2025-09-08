<?php

namespace App\Http\Controllers\Admin\People;

use App\Http\Controllers\Controller;
use App\Models\Admin\People\Delegate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DelegateController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $delegates = Delegate::with('branch','agent', 'employee')->where('company_id', $user->company_id)->get();
        return view('backend.pages.people.delegates', compact('delegates'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $delegates = Delegate::with('branch')->where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($delegates);
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
                'branch_id'                 => 'required|exists:branches,id', 
                'country_id'                => 'required|exists:countries,id',
                'state'                     => 'nullable|string|max:255',
                'sponsor_type'              => 'required|string|max:255',
                'agent_id'                  => 'nullable|exists:agents,id', 
                'employee_id'               => 'nullable|exists:employees,id',
                'delegate_photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'opening_balance_sheet'     => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'current_address'           => 'nullable|string|max:1000',
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
            $lastDelegate = Delegate::where('company_id', $company->id)
            ->where('delegate_code', 'like', 'DEL' . $companyNumber . '%')
            ->orderByDesc('delegate_code')
            ->first();
        
            if ($lastDelegate && preg_match('/DEL' . $companyNumber . '(\d+)/', $lastDelegate->delegate_code, $codeMatch)) {
                $lastNumber = (int)$codeMatch[1];
            } else {
                $lastNumber = 0;
            }
            
            $nextNumber = $lastNumber + 1;
            $delegateCode = 'DEL' . $companyNumber . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Handle file uploads
            $uploadFile = function ($fileField) use ($request) {
                if ($request->hasFile($fileField) && $request->file($fileField)->isValid()) {
                    $file = $request->file($fileField);
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    return $file->storeAs('uploads/delegate', $filename, 'public');
                }
                return null;
            };

            $data = $request->only([
                'branch_id','first_name', 'last_name', 'phone_number', 'email',
                'opening_balance', 'state', 'sponsor_type', 'country_id', 'agent_id', 'employee_id',
                'current_address', 'note', 'status'
            ]);

            // Set user ID
            $data['user_id'] = $user_id;
            $data['delegate_code'] = $delegateCode;
            $data['company_id'] = $user->company_id;

            // Set file paths
            $data['delegate_photo']         = $uploadFile('delegate_photo');
            $data['opening_balance_sheet']  = $uploadFile('opening_balance_sheet');

            Delegate::create($data);

            return response()->json(['status' => 'success','message' => 'Delegates added successfully']);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail','errors' => $e->validator->errors(),], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage(),], 500);
        }
    }


    public function show($id)
    {
        $delegate = Delegate::with('country')->findOrFail($id);
        return response()->json($delegate);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        try {
            $delegate = Delegate::findOrFail($id);
            if ($delegate->delegate_photo && Storage::disk('public')->exists($delegate->delegate_photo)) {
                Storage::disk('public')->delete($delegate->delegate_photo);
            }

            if ($delegate->opening_balance_sheet && Storage::disk('public')->exists($delegate->opening_balance_sheet)) {
                Storage::disk('public')->delete($delegate->opening_balance_sheet);
            }
            $delegate->delete();
            return response()->json(['status' => 'success','message' => 'Delegate and associated files deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(),]);
        }
    }
}
