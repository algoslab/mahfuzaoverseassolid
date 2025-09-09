<?php

namespace App\Http\Controllers\Supper_Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Payroll\Expense\ExpenseCategory;
use App\Models\Supper_Admin\Payroll\FestivalBonus;
use App\Models\Supper_Admin\Payroll\MobileAllowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FestivalBonusController extends Controller
{
    public function index()
    {
        $festivalBonuses = FestivalBonus::get();
        return view('supper_admin.pages.payroll.festival-bonus', compact('festivalBonuses'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'month'      => 'required|string',
                'amount_type'    => 'required|in:Percentage,Fixed',
                'amount'      => 'required'
            ]);
            FestivalBonus::create([
                'month'      => $request->input('month'),
                'amount_type'      => $request->input('amount_type'),
                'amount'      => $request->input('amount'),
                'note'  => $request->input('note')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Festival bonus added Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        $festivalBonus = FestivalBonus::findOrFail($id);
        return response()->json($festivalBonus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'month'      => 'required|string',
                'amount_type'    => 'required|in:Percentage,Fixed',
                'amount'      => 'required'
            ]);

            $festivalBonus = FestivalBonus::findOrFail($id);
            $festivalBonus->month = $request->month;
            $festivalBonus->amount_type = $request->amount_type;
            $festivalBonus->amount = $request->amount;
            $festivalBonus->note = $request->note;
            $festivalBonus->save();

            return response()->json(['status' => 'success', 'message' => 'Festival bonus updated successfully']);
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
            $festivalBonus = FestivalBonus::findOrFail($id);
            $festivalBonus->delete();
            return response()->json(['status' => 'success', 'message' => 'Festival bonus deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
