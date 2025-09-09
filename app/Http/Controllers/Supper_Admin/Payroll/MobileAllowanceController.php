<?php

namespace App\Http\Controllers\Supper_Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Admin\HRM\Employee;
use App\Models\Supper_Admin\Payroll\IncAndDec;
use App\Models\Supper_Admin\Payroll\MobileAllowance;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MobileAllowanceController extends Controller
{
    public function index()
    {
        $mobileAllowances = MobileAllowance::get();
        return view('supper_admin.pages.payroll.mobile-allowance', compact('mobileAllowances'));
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
                'impression_type'    => 'required|in:Increment,Decrement',
                'start_month'      => 'required|string',
                'amount_type'    => 'required|in:Percentage,Fixed',
                'amount'      => 'required'
            ]);
            MobileAllowance::create([
                'department_id'      => $request->input('department_id'),
                'employee_id'      => $request->input('employee_id'),
                'impression_type'      => $request->input('impression_type'),
                'start_month'      => $request->input('start_month'),
                'amount_type'      => $request->input('amount_type'),
                'amount'      => $request->input('amount'),
                'note'  => $request->input('note')
            ]);
            $employee = Employee::find($request->input('employee_id'));
            $employee->update(['mobile_allowance' => $request->input('amount')]);
            return response()->json(['status' => 'success', 'message' => 'Mobile Allowance added Successfully']);
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
            $mobileAllowance = MobileAllowance::findOrFail($id);
            $mobileAllowance->delete();
            return response()->json(['status' => 'success', 'message' => 'Mobile allowance deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
