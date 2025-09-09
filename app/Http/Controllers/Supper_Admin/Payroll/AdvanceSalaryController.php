<?php

namespace App\Http\Controllers\Supper_Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Payroll\AdvanceSalary;
use App\Models\Supper_Admin\Payroll\MobileAllowance;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdvanceSalaryController extends Controller
{
    public function index()
    {
        $advanceSalaries = AdvanceSalary::get();
        return view('supper_admin.pages.payroll.advance-salary', compact('advanceSalaries'));
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
                'month'      => 'required|string',
                'payment_account'    => 'required|in:Bank Account,Cash in Hand,Mobile Banking,Office Assets',
                'currency'      => 'required',
                'amount'      => 'required',
                'bdt_amount'      => 'required',
                'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240' // 10MB max
            ]);
            $attachmentPath = null;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $attachmentPath = $file->storeAs('uploads/advance_salaries', $filename, 'public');
            }

            AdvanceSalary::create([
                'department_id'      => $request->input('department_id'),
                'employee_id'      => $request->input('employee_id'),
                'month'      => $request->input('month'),
                'payment_account'      => $request->input('payment_account'),
                'currency'      => $request->input('currency'),
                'amount'      => $request->input('amount'),
                'bdt_amount'      => $request->input('bdt_amount'),
                'attachment'         => $attachmentPath,
                'note'  => $request->input('note')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Advance salary added Successfully']);
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
            $advanceSalary = AdvanceSalary::findOrFail($id);
            $advanceSalary->delete();
            return response()->json(['status' => 'success', 'message' => 'Advance salary deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
