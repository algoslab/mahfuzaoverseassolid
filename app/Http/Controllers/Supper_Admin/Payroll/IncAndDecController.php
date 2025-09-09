<?php

namespace App\Http\Controllers\Supper_Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Payroll\IncAndDec;
use App\Models\Supper_Admin\Payroll\PerformanceBonus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IncAndDecController extends Controller
{
    public function index()
    {
        $incAndDecs = IncAndDec::get();
        return view('supper_admin.pages.payroll.inc-and-dec', compact('incAndDecs'));
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
            IncAndDec::create([
                'department_id'      => $request->input('department_id'),
                'employee_id'      => $request->input('employee_id'),
                'impression_type'      => $request->input('impression_type'),
                'start_month'      => $request->input('start_month'),
                'amount_type'      => $request->input('amount_type'),
                'amount'      => $request->input('amount'),
                'note'  => $request->input('note')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Inc and Dec added Successfully']);
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
            $incAndDec = IncAndDec::findOrFail($id);
            $incAndDec->delete();
            return response()->json(['status' => 'success', 'message' => 'Inc and Dec deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
