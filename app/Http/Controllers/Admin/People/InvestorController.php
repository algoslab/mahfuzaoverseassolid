<?php

namespace App\Http\Controllers\Admin\People;

use App\Http\Controllers\Controller;
use App\Models\Admin\HRM\Employee;
use App\Models\Admin\People\Investor;
use App\Models\Supper_Admin\Location\Country;
use App\Models\Supper_Admin\Location\Currency;
use App\Models\Supper_Admin\Location\District;
use App\Models\Supper_Admin\Location\Division;
use App\Models\TransactionPurpose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InvestorController extends Controller
{
    public function index()
    {
        $countries = Country::select('id', 'name')->get();
        $districts = District::select('id', 'name')->get();
        $divisions = Division::select('id', 'name')->get();
        $employees = Employee::select('id', 'first_name', 'last_name')->get();
        $transactionPurposes = TransactionPurpose::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name')->get();
        $investors = Investor::with('employee')->latest()->get();
        return view('backend.pages.people.investor', compact('investors','countries','districts','divisions','employees','transactionPurposes','currencies'));
    }

    public function show($id)
    {
        $investor = Investor::findOrFail($id);
        return response()->json($investor);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cell_no' => 'required|string|max:20',
            'email' => 'required|email|unique:investors,email|max:255',
            'password' => 'required|string|min:6|max:255',
            'investor_photo' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nid_scan_copy' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'agreement_scan_copy' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'attachment' => 'nullable|array',
            'attachment.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'country_id' => 'required|exists:countries,id',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'employee_id' => 'required|exists:employees,id',
            'current_address' => 'required|string|max:1000',
            'permanent_address' => 'required|string|max:1000',
            'note' => 'nullable|string|max:1000',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($data['password']);
        
        $data['recieved_no'] = random_int(100000000, 999999999);
        
        // Handle file uploads
        foreach(['investor_photo','nid_scan_copy','agreement_scan_copy'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $data[$fileField] = $request->file($fileField)->store('investors/'.$fileField, 'public');
            }
        }
        
        // Handle multiple attachments
        if ($request->hasFile('attachment')) {
            $attachments = [];
            foreach ($request->file('attachment') as $file) {
                $attachments[] = $file->store('investors/attachments', 'public');
            }
            $data['attachment'] = $attachments;
        }
        
        $investor = Investor::create($data);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Investor added successfully.', 'data' => $investor]);
        }
        return redirect()->route('admin.investors.index')->with('success', 'Investor added successfully.');
    }

    public function update(Request $request, $id)
    {
        $investor = Investor::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cell_no' => 'required|string|max:20',
            'email' => 'required|email|unique:investors,email,'.$id.'|max:255',
            'password' => 'nullable|string|min:6|max:255',
            'investor_photo' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nid_scan_copy' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'agreement_scan_copy' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'attachment' => 'nullable|array',
            'attachment.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'country_id' => 'required|exists:countries,id',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'employee_id' => 'required|exists:employees,id',
            'current_address' => 'required|string|max:1000',
            'permanent_address' => 'required|string|max:1000',
            'note' => 'nullable|string|max:1000',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        
        // Handle file uploads
        foreach(['investor_photo','nid_scan_copy','agreement_scan_copy'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $data[$fileField] = $request->file($fileField)->store('investors/'.$fileField, 'public');
            }
        }
        
        if ($request->hasFile('attachment')) {
            $attachments = [];
            foreach ($request->file('attachment') as $file) {
                $attachments[] = $file->store('investors/attachments', 'public');
            }
            $data['attachment'] = $attachments;
        }
        
        $investor->update($data);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Investor updated successfully.', 'data' => $investor]);
        }
        return redirect()->route('admin.investors.index')->with('success', 'Investor updated successfully.');
    }

    public function destroy($id, Request $request)
    {
        $investor = Investor::findOrFail($id);
        $investor->delete();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Investor deleted successfully.']);
        }
        return redirect()->route('admin.investors.index')->with('success', 'Investor deleted successfully.');
    }
} 