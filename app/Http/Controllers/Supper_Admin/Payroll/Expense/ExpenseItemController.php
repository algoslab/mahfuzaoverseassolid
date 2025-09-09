<?php

namespace App\Http\Controllers\Supper_Admin\Payroll\Expense;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Payroll\Expense\ExpenseItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ExpenseItemController extends Controller
{
    public function index()
    {
        $expenseItems = ExpenseItem::get();
        return view('supper_admin.pages.payroll.expense.expense-item', compact('expenseItems'));
    }

    public function enabledIndex(Request $request)
    {
        if ($request->has('expense_category_id') && $request->expense_category_id) {
            $categoryId = $request->get('expense_category_id');
            $expenseItems = ExpenseItem::where('status', 'Enabled')
                ->where('expense_category_id', $categoryId)
                ->get();
        } else {
            $expenseItems = ExpenseItem::where('status', 'Enabled')->get();
        }
        return response()->json($expenseItems);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'expense_category_id'      => 'required|integer',
                'expense_item_name'      => 'required|string|max:255|unique:expense_items,expense_item_name',
                'status'    => 'required|in:Enabled,Disabled'
            ]);
            ExpenseItem::create([
                'expense_category_id'      => $request->input('expense_category_id'),
                'expense_item_name'      => $request->input('expense_item_name'),
                'note'  => $request->input('note'),
                'status'    => $request->input('status') === 'Enabled' ? 'Enabled' : 'Disabled'
            ]);
            return response()->json(['status' => 'success', 'message' => 'Expense item added Successfully']);
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
        $expenseItem = ExpenseItem::findOrFail($id);
        return response()->json($expenseItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'expense_category_id'      => 'required|integer',
                'expense_item_name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('expense_items')->ignore($id),
                ],
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $expenseItem = ExpenseItem::findOrFail($id);
            $expenseItem->expense_category_id = $request->expense_category_id;
            $expenseItem->expense_item_name = $request->expense_item_name;
            $expenseItem->note = $request->note;
            $expenseItem->status = $request->status === 'Enabled' ? 'Enabled' : 'Disabled';

            $expenseItem->save();

            return response()->json(['status' => 'success', 'message' => 'Expense item updated successfully']);
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
            $expenseItem = ExpenseItem::findOrFail($id);
            $expenseItem->delete();
            return response()->json(['status' => 'success', 'message' => 'Expense item deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
