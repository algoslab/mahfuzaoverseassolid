<?php

namespace App\Http\Controllers\Supper_Admin\Attendance_Leave;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Attendance_Leave\Attendance;
use App\Models\Supper_Admin\Attendance_Leave\Leave;
use App\Models\Supper_Admin\Attendance_Leave\LeaveDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::get();
        return view('supper_admin.pages.attendanceAndLeave.leave', compact('leaves'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'department_id'      => 'required|integer',
                'employee_id'      => 'required|integer',
                'leave_type'    => 'required|in:Half Day Leave,Full Day Leave',
                'no_of_days'      => 'required'
            ]);
            $attachmentPath = null;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $attachmentPath = $file->storeAs('uploads/leaves', $filename, 'public');
            }
            $leave = Leave::create([
                'department_id'      => $request->input('department_id'),
                'employee_id'      => $request->input('employee_id'),
                'leave_type'      => $request->input('leave_type'),
                'no_of_days'      => $request->input('no_of_days'),
                'shift'      => $request->leave_type === 'Half Day Leave' ? $request->input('shift') : 'Full Day',
                'attachment'         => $attachmentPath,
                'note'  => $request->input('note')
            ]);
            if($request->input('leave_date')) {
                if ($request->leave_type === 'Full Day Leave') {
                    [$start, $end] = explode('→', $request->leave_date);
                    $startDate = Carbon::createFromFormat('Y-m-d', trim($start));
                    $endDate = Carbon::createFromFormat('Y-m-d', trim($end));

                    $allDates = collect();
                    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                        $allDates->push($date->format('Y-m-d'));
                    }
                    foreach ($allDates as $singleDate) {
                        LeaveDate::create([
                            'leave_id' => $leave->id, // or any logic
                            'leave_date' => $singleDate
                        ]);
                    }

                } else {
                    LeaveDate::create([
                        'leave_id' => $leave->id, // or any logic
                        'leave_date' => $request->leave_date
                    ]);
                }
            }
            return response()->json(['status' => 'success', 'message' => 'Leave added Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $leave = Leave::with(['leaveDates', 'department', 'employee'])->findOrFail($id);
        return response()->json($leave);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $leave = Leave::findOrFail($id);
            if(isset($leave->leaveDates)){
                $leave->leaveDates()->delete();
            }
            $leave->delete();
            return response()->json(['status' => 'success', 'message' => 'Leave deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function withdraw(string $id)
    {
        try {
            $leaveDate = LeaveDate::findOrFail($id);
            $leave = Leave::where('id', $leaveDate->leave_id)->first();
            if(isset($leave)){
                if($leave->leave_type === 'Full Day Leave'){
                    $leave->update(['no_of_days'=>$leave->no_of_days - 1]);
                } else {
                    $leave->update(['no_of_days'=>0]);
                }
            }
            $leaveDate->delete();
            return response()->json(['status' => 'success', 'message' => 'Leave withdraw successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
