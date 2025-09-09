<?php

namespace App\Http\Controllers\Supper_Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Admin\HRM\Employee;
use App\Models\Supper_Admin\Payroll\FestivalBonus;
use App\Models\Supper_Admin\Payroll\SalaryGenerate;
use App\Models\Supper_Admin\Payroll\SalaryGenerateEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalaryGenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salaries = SalaryGenerate::get();
        return view('supper_admin.pages.payroll.salary-generate', compact('salaries'));
    }

    public function unpaidSalaryEmployees(Request $request)
    {
        if ($request->has('salary_generate_id') && $request->salary_generate_id) {
            $salaryGenerateId = $request->get('salary_generate_id');
            $employees = SalaryGenerateEmployee::with(['employee'])->where('is_paid', 'Not Yet')
                ->where('salary_generate_id', $salaryGenerateId)
                ->get();
        } else {
            $employees = SalaryGenerateEmployee::with(['employee'])->where('is_paid', 'Not Yet')->get();

        }

        return response()->json($employees);}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'month_year' => 'required|string'
            ]);

            $monthYear = $request->month_year;
            $daysInMonth = Carbon::createFromFormat('Y-m', $monthYear)->daysInMonth;

    // Check if salary already generated for this month
            if (SalaryGenerate::where('month_year', $monthYear)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Salary already generated for this month.'
                ]);
            }

    // Get global festival bonus amount for the month
            $festivalBonusAmount = optional(
                FestivalBonus::where('month', $monthYear)->first()
            )->amount ?? 0;

// Fetch employees with salary components
            $employees = Employee::select(
                'employees.*',
                DB::raw("CASE WHEN employees.is_mobile_bill = 1 THEN COALESCE(employees.mobile_allowance, 0) ELSE 0 END AS mobileAllowance"),
                DB::raw('COALESCE(inc.increment, 0) AS totalIncrement'),
                DB::raw('COALESCE(decmt.decrement, 0) AS totalDecrement'),
                DB::raw('COALESCE(advanceS.advanceSalary, 0) AS totalAdvanceSalary'),
                DB::raw('COALESCE(performanceB.performanceBonus, 0) AS totalPerformanceBonus'),
                DB::raw('COALESCE(a.attendance, 0) AS totalAttendance'),
                DB::raw('COALESCE(hdl.halfDay, 0) AS totalHalfDay'),
                DB::raw('COALESCE(fdl.fullDay, 0) AS totalFullDay'),
                DB::raw('COALESCE(h.holiday, 0) AS totalHoliday'),
                DB::raw('COALESCE(w.weekend, 0) AS totalWeekend'),
            )
                ->leftJoin(DB::raw("
    (SELECT employee_id, SUM(amount) AS performanceBonus
     FROM performance_bonuses
     WHERE month = ?
     GROUP BY employee_id
) AS performanceB"), 'employees.id', '=', 'performanceB.employee_id')

                ->leftJoin(DB::raw("
    (SELECT employee_id, SUM(amount) AS increment
     FROM inc_and_decs
     WHERE impression_type = 'Increment' AND start_month <= ?
     GROUP BY employee_id
) AS inc"), 'employees.id', '=', 'inc.employee_id')

                ->leftJoin(DB::raw("
    (SELECT employee_id, SUM(amount) AS decrement
     FROM inc_and_decs
     WHERE impression_type = 'Decrement' AND start_month <= ?
     GROUP BY employee_id
) AS decmt"), 'employees.id', '=', 'decmt.employee_id')

                ->leftJoin(DB::raw("
    (SELECT employee_id, SUM(bdt_amount) AS advanceSalary
     FROM advance_salaries
     WHERE month = ?
     GROUP BY employee_id
) AS advanceS"), 'employees.id', '=', 'advanceS.employee_id')
                ->leftJoin(DB::raw("
    (SELECT employee_id, count(id) AS attendance
     FROM attendances
     WHERE DATE_FORMAT(date, '%Y-%m') = ?
     GROUP BY employee_id
) AS a"), 'employees.id', '=', 'a.employee_id')
                ->leftJoin(DB::raw("
    (SELECT employee_id, count(id) AS holiday
     FROM attendances
     WHERE DATE_FORMAT(date, '%Y-%m') = ? AND is_holiday = 1
     GROUP BY employee_id
    ) AS h
"), 'employees.id', '=', 'h.employee_id')

                ->leftJoin(DB::raw("
    (SELECT employee_id, count(id) AS weekend
     FROM attendances
     WHERE DATE_FORMAT(date, '%Y-%m') = ? AND is_weekend = 1
     GROUP BY employee_id
    ) AS w
"), 'employees.id', '=', 'w.employee_id')
                ->leftJoin(DB::raw("
    (SELECT employee_id, leave_id, sum(no_of_days) AS fullDay
     FROM leaves, leave_dates
     WHERE leave_type = 'Full Day Leave' AND leave_dates.leave_id = leaves.id AND DATE_FORMAT(leave_date, '%Y-%m') = ?
     GROUP BY employee_id, leave_id
) AS fdl"), 'employees.id', '=', 'fdl.employee_id')
                ->leftJoin(DB::raw("
    (SELECT employee_id, leave_id, sum(no_of_days) AS halfDay
     FROM leaves, leave_dates
     WHERE leave_type = 'Half Day Leave' AND leave_dates.leave_id = leaves.id AND DATE_FORMAT(leave_date, '%Y-%m') = ?
     GROUP BY employee_id, leave_id
) AS hdl"), 'employees.id', '=', 'hdl.employee_id')

                ->addBinding([$monthYear, $monthYear, $monthYear, $monthYear, $monthYear, $monthYear, $monthYear, $monthYear, $monthYear], 'select')
                ->where('employees.status', 1)
                ->get();

// Create salary generate record
            $totalBaseSalary = 0;
            $totalGrandTotalSalary = 0;

            $salary = SalaryGenerate::create([
                'month_year'            => $monthYear,
                'total_employee'        => $employees->count(),
                'total_employee_basic_salary' => 0,
                'total_employee_grand_total_salary' => 0,
                'user_id'               => Auth::id(),
                'note'                  => $request->input('note')
            ]);

            foreach ($employees as $employee) {
                $base = $employee->basic_salary_monthly ?? 0;
                $perDaySalary = $employee->basic_salary_daily ?? 0;
                $mobile = $employee->mobileAllowance;
                $increment = $employee->totalIncrement;
                $decrement = $employee->totalDecrement;
                $monthlySalary = $base + $increment - $decrement;
                $advance = $employee->totalAdvanceSalary;
                $performance = $employee->totalPerformanceBonus;
                $present = $employee->totalAttendance;
                $days = $daysInMonth;
                $absent = $days - $present;
                $halfDay = $employee->totalHalfDay;
                $fullDay = $employee->totalFullDay;
                $holiday = $employee->totalHoliday;
                $holidayAmount = $perDaySalary * $holiday;
                $weekend = $employee->totalWeekend;
                $weekendAmount = $perDaySalary * $weekend;

                $netSalary = $perDaySalary * $present;
                $finalSalary = $netSalary + $mobile - $advance + $performance + $festivalBonusAmount;

                $incDecValue = $increment != 0 ? $increment : ($decrement != 0 ? $decrement : 0);

                SalaryGenerateEmployee::create([
                    'salary_generate_id'  => $salary->id,
                    'employee_id'         => $employee->id,
                    'month_year'          => $monthYear,
                    'number_of_days'    => $days,
                    'employee_present'    => $present,
                    'employee_absent'    => $absent,
                    'employee_half_day'   => $halfDay,
                    'employee_full_day'   => $fullDay,
                    'holidays'   => $holiday,
                    'employee_holidays_amount'   => $holidayAmount,
                    'weekend_days'   => $weekend,
                    'employee_weekend_days_amount'   => $weekendAmount,
                    'mobile_allowance'    => $mobile,
                    'performance_bonus'   => $performance,
                    'inc_dec'             => $incDecValue,
                    'advance_salary'      => $advance,
                    'festival_bonus'      => $festivalBonusAmount,
                    'employee_per_day_salary'     => $perDaySalary,
                    'employee_total_present_amount'     => $netSalary - $weekendAmount -$holidayAmount,
                    'employee_net_salary'     => $netSalary,
                    'employee_basic_salary'     => $base,
                    'employee_monthly_salary'     => $monthlySalary,
                    'employee_total_salary'     => $netSalary,
                    'employee_grand_total_salary'     => $finalSalary
                ]);

                $totalBaseSalary += $base;
                $totalGrandTotalSalary += $finalSalary;
            }

            // Update total salary after loop
            $salary->update([
                'total_employee_basic_salary' => $totalBaseSalary,  'total_employee_grand_total_salary' => $totalGrandTotalSalary
            ]);


            return response()->json(['status' => 'success', 'message' => 'Salary Generated Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function salaryDistribution(Request $request)
    {
        try {
            $request->validate([
                'month_year'      => 'required|string',
                'employee_id'      => 'required|integer',
                'payment_method'    => 'required|in:Bank Account,Cash in Hand,Mobile Banking,Office Assets',
                'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max

            ]);

            $attachmentPath = null;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $attachmentPath = $file->storeAs('uploads/salary-distribution', $filename, 'public');
            }
            $employeeSalary = SalaryGenerateEmployee::where('employee_id', $request->employee_id)->where('month_year', $request->month_year)->first();
            $employeeSalary->is_paid = 'Received';
            $employeeSalary->payment_method = $request->payment_method;
            $employeeSalary->transaction_note = $request->transaction_note;
            $employeeSalary->attachment = $attachmentPath;
            $employeeSalary->note = $request->note;
            $employeeSalary->save();

            return response()->json(['status' => 'success', 'message' => 'Salary Distributed Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalaryGenerate $salaryGenerate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $salaryGenerate = SalaryGenerate::with(['salaryGenerateEmployees', 'salaryGenerateEmployees.employee', 'salaryGenerateEmployees.employee.department', 'salaryGenerateEmployees.employee.designation'])->findOrFail($id);
        return response()->json($salaryGenerate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalaryGenerate $salaryGenerate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $salaryGenerate = SalaryGenerate::findOrFail($id);
            if($salaryGenerate->salaryGenerateEmployees) {
                $salaryGenerate->salaryGenerateEmployees()->delete();
            }
            $salaryGenerate->delete();
            return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
