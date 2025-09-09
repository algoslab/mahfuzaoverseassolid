<?php

namespace App\Http\Controllers\Supper_Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Payroll\Expense\ExpenseItem;
use App\Models\Supper_Admin\Payroll\PerformanceBonus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PerformanceBonusController extends Controller
{
    public function index()
    {
        $performanceBonuses = PerformanceBonus::get();
        return view('supper_admin.pages.payroll.performance-bonus', compact('performanceBonuses'));
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
                'impression_type'    => 'required|in:Good impression,Bad impression',
                'month'      => 'required|string',
                'amount_type'    => 'required|in:Percentage,Fixed',
                'amount'      => 'required'
            ]);
            PerformanceBonus::create([
                'department_id'      => $request->input('department_id'),
                'employee_id'      => $request->input('employee_id'),
                'impression_type'      => $request->input('impression_type'),
                'month'      => $request->input('month'),
                'amount_type'      => $request->input('amount_type'),
                'amount'      => $request->input('amount'),
                'note'  => $request->input('note')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Performance Bonus added Successfully']);
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
            $performanceBonus = PerformanceBonus::findOrFail($id);
            $performanceBonus->delete();
            return response()->json(['status' => 'success', 'message' => 'Performance bonus deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
