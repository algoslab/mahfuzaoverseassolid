<?php

namespace App\Http\Controllers\Admin\Enquiry;

use App\Http\Controllers\Controller;
use App\Models\Admin\Enquiry\PhoneCall;
use App\Models\Admin\Enquiry\PhoneCallFollowup;
use App\Models\Admin\HRM\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PhoneCallFollowupController extends Controller
{
    public function index(Request $request)
    {
        $query = PhoneCallFollowup::query();
        if ($request->has('phone_call_id')) {
            $query->where('phone_call_id', $request->phone_call_id);
        }
        return response()->json($query->with(['phoneCall', 'employee'])->latest()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'phone_call_id' => 'required|exists:phone_calls,id',
            'employee_id' => 'nullable|exists:users,id',
            'process' => 'required|in:Continue,Close,Not Started Yet,Buissness Man',
            'note' => 'nullable|string',
            'followup_date' => 'nullable|date',
            'followup_time' => 'nullable|date_format:H:i',
        ]);
        $employeeId = Employee::where('user_id', Auth::id())->select('id')->first();
        $data['employee_id'] = $employeeId->id ?? '';

        $followup = PhoneCallFollowup::create($data);
        if($followup){
            $phoneCall = PhoneCall::find($followup->phone_call_id);
            $phoneCall->process = $followup->process;
            if( $followup->followup_date){
                $phoneCall->followup_date = $followup->followup_date;
            }
            if( $followup->followup_time){
                $phoneCall->followup_time = $followup->followup_time;
            }
            $phoneCall->save();
        }
        return response()->json(['status' => 'success', 'data' => $followup]);
    }

    public function show($id)
    {
        $followup = PhoneCallFollowup::with(['phoneCall', 'employee'])->findOrFail($id);
        return response()->json($followup);
    }

    public function update(Request $request, $id)
    {
        $followup = PhoneCallFollowup::findOrFail($id);
        $data = $request->validate([
            'process' => 'required|in:Continue,Close,Not Started Yet,Buissness Man',
            'note' => 'nullable|string',
            'followup_date' => 'nullable|date',
            'followup_time' => 'nullable|date_format:H:i',
        ]);
        $followup->update($data);
        if($followup){
            $phoneCall = PhoneCall::find($followup->phone_call_id);
            $phoneCall->process = $followup->process;
            if( $followup->followup_date){
                $phoneCall->followup_date = $followup->followup_date;
            }
            if( $followup->followup_time){
                $phoneCall->followup_time = $followup->followup_time;
            }
            $phoneCall->save();
        }
        return response()->json(['status' => 'success', 'data' => $followup]);
    }

    public function destroy($id)
    {
        $followup = PhoneCallFollowup::findOrFail($id);
        $followup->delete();
        return response()->json(['status' => 'success']);
    }
}
