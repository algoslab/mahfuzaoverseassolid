<?php

namespace App\Http\Controllers\Admin\Enquiry;

use App\Http\Controllers\Controller;
use App\Models\Admin\Enquiry\HowFindUs;
use App\Models\Admin\Process\CandidateType;
use App\Models\FindUs;
use App\Models\Admin\Enquiry\PhoneCall;
use App\Models\Supper_Admin\Location\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\HRM\Employee;
use Illuminate\Support\Facades\Validator;

class PhoneCallController extends Controller
{
    public function index()
    {
        $phoneCalls = PhoneCall::with('country', 'candidateType', 'employee')->latest()->get();
        $countries = Country::select('id', 'name')->get();
        $howFindUs = HowFindUs::select('id', 'name')->get();
        $candidateTypes = CandidateType::select('id', 'name')->get();
        $employees = Employee::select('id', 'employee_code', 'first_name', 'last_name')->with('phone_call_followups' ,'phone_call_followups.phoneCall')->get();
        
        if (request()->ajax()) {
            return response()->json([
                'html' => view('backend.components.enquiry.phone_call_table_rows', compact('phoneCalls'))->render()
            ]);
        }
        
        return view('backend.pages.enquiry.phone_call', compact('phoneCalls', 'countries', 'candidateTypes', 'employees', 'howFindUs'));
    }

    public function show($id)
    {
        $phoneCall = PhoneCall::findOrFail($id);
        return response()->json($phoneCall);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'             => 'required',
            'full_name'         => 'required|string',
            'country_id'        => 'required|integer',
            'candidate_type_id' => 'required|integer',
            'how_find_us_id'    => 'required|string',
            'email'             => 'nullable|email',
            'note'              => 'nullable|string',
            'followup_date'     => 'nullable|date',
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

        $phoneCall = PhoneCall::create($request->all());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Phone call record saved successfully.', 'data' => $phoneCall]);
        }

        return redirect()->route('admin.phone-calls.index')->with('success', 'Phone call record saved successfully.');
    }

    public function update(Request $request, PhoneCall $phone_call)
    {
        $validator = Validator::make($request->all(), [
            'phone'             => 'required',
            'full_name'         => 'required|string',
            'country_id'        => 'required|integer',
            'candidate_type_id' => 'required|integer',
            'how_find_us_id'       => 'required|string',
            'email'             => 'nullable|email',
            'note'              => 'nullable|string',
            'followup_date'     => 'nullable|date',
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

        $phone_call->update($request->all());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Phone call record updated successfully.', 'data' => $phone_call]);
        }

        return redirect()->route('admin.phone-calls.index')->with('success', 'Phone call record updated successfully.');
    }

    public function destroy(PhoneCall $phone_call, Request $request)
    {
        $phone_call->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Phone call record deleted successfully.']);
        }

        return redirect()->route('admin.phone-calls.index')->with('success', 'Phone call record deleted successfully.');
    }
}
