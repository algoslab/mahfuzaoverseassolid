<?php

namespace App\Http\Controllers\Supper_Admin\Attendance_Leave;

use App\Http\Controllers\Controller;
use App\Models\Admin\HRM\Employee;
use App\Models\Admin\MyOffice\Holiday;
use App\Models\Supper_Admin\Attendance_Leave\Attendance;
use App\Models\Supper_Admin\Attendance_Leave\Weekend;
use App\Models\Supper_Admin\Payroll\Expense\ExpenseItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::get();
        return view('supper_admin.pages.attendanceAndLeave.attendance', compact('attendances'));
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
                'date'      => 'required|string',
                'check_in'      => 'required|string',
                'check_out'      => 'required|string'
            ]);
            // Check if attendance already exists for this date
            if (Attendance::where('date', $request->input('date'))->where('employee_id', $request->input('employee_id'))->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee attendance already exists for this date.'
                ]);
            }
            $dateDetails = Carbon::parse($request->input('date'))->format('l, jS \\of F Y');
            $checkHoliday = Holiday::where('date', $request->input('date'))->first();
            if (isset($checkHoliday)) {
                $holiday = 1;
            } else{
                $holiday = 0;
            }
            $day = ucfirst(strtolower(Carbon::parse($request->input('date'))->format('l')));
            $checkWeekend = Employee::whereRaw('LOWER(weekend_day) = ?', [strtolower($day)])->first();
            if (isset($checkWeekend)) {
                $weekend = 1;
            } else{
                $weekend = 0;
            }
            Attendance::create([
                'department_id'      => $request->input('department_id'),
                'employee_id'      => $request->input('employee_id'),
                'date'      => $request->input('date'),
                'date_details'      => $dateDetails,
                'check_in'      => $request->input('check_in'),
                'check_out'      => $request->input('check_out'),
                'is_holiday'      => $holiday,
                'is_weekend'      => $weekend,
                'note'  => $request->input('note')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Attendance added Successfully']);
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
        $attendance = Attendance::findOrFail($id);
        return response()->json($attendance);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'department_id'      => 'required|integer',
                'employee_id'      => 'required|integer',
                'date'      => 'required|string',
                'check_in'      => 'required|string',
                'check_out'      => 'required|string'
            ]);
            // Check if attendance already exists for this date
            if (Attendance::where('date', $request->input('date'))->where('employee_id', $request->input('employee_id'))->where('id', '!=', $id)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee attendance already exists for this date.'
                ]);
            }
            $dateDetails = Carbon::parse($request->input('date'))->format('l, jS \\of F Y');
            $checkHoliday = Holiday::where('date', $request->input('date'))->first();
            if (isset($checkHoliday)) {
                $holiday = 1;
            } else{
                $holiday = 0;
            }
            $day = ucfirst(strtolower(Carbon::parse($request->input('date'))->format('l')));
            $checkWeekend = Employee::whereRaw('LOWER(weekend_day) = ?', [strtolower($day)])->first();
            if (isset($checkWeekend)) {
                $weekend = 1;
            } else{
                $weekend = 0;
            }
            $attendance = Attendance::findOrFail($id);
            $attendance->department_id = $request->department_id;
            $attendance->employee_id = $request->employee_id;
            $attendance->date = $request->date;
            $attendance->date_details = $dateDetails;
            $attendance->check_in = $request->check_in;
            $attendance->check_out = $request->check_out;
            $attendance->is_holiday = $holiday;
            $attendance->is_weekend = $weekend;
            $attendance->note = $request->note;
            $attendance->save();

            return response()->json(['status' => 'success', 'message' => 'Attendance updated successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();
            return response()->json(['status' => 'success', 'message' => 'Attendance deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
