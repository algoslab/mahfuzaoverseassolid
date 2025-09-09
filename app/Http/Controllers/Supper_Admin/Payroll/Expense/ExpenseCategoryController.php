<?php

namespace App\Http\Controllers\Supper_Admin\Payroll\Expense;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Payroll\Expense\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expenseCategories = ExpenseCategory::get();
        return view('supper_admin.pages.payroll.expense.expense-category', compact('expenseCategories'));
    }

    public function enabledIndex()
    {
        $expenseCategories = ExpenseCategory::where('status', 'Enabled')->get();
        return response()->json($expenseCategories);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'account_type'    => 'required|in:Assets,Expense',
                'expense_category_name'      => 'required|string|max:255|unique:expense_categories,expense_category_name',
                'expense_category_code'      => 'required|string|max:255|unique:expense_categories,expense_category_code',
                'opening_balance_sheet' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $openingBalanceSheetPath = null;

            if ($request->hasFile('opening_balance_sheet')) {
                $file = $request->file('opening_balance_sheet');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $openingBalanceSheetPath = $file->storeAs('uploads/expense_categories', $filename, 'public');
            }

            ExpenseCategory::create([
                'account_type'      => $request->input('account_type'),
                'expense_category_name'  => $request->input('expense_category_name'),
                'expense_category_code'  => $request->input('expense_category_code'),
                'opening_balance'  => $request->input('opening_balance'),
                'opening_balance_sheet'         => $openingBalanceSheetPath,
                'note'  => $request->input('note'),
                'status'    => $request->input('status') === 'Enabled' ? 'Enabled' : 'Disabled'
            ]);
            return response()->json(['status' => 'success', 'message' => 'Expense category added Successfully']);
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
        $expenseCategory = ExpenseCategory::findOrFail($id);
        return response()->json($expenseCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'account_type'    => 'required|in:Assets,Expense',
                'expense_category_name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('expense_categories')->ignore($id),
                ],
                'expense_category_code' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('expense_categories')->ignore($id),
                ],
                'opening_balance_sheet' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $expenseCategory = ExpenseCategory::findOrFail($id);
            $expenseCategory->account_type = $request->account_type;
            $expenseCategory->expense_category_name = $request->expense_category_name;
            $expenseCategory->expense_category_code = $request->expense_category_code;
            $expenseCategory->opening_balance = $request->opening_balance;
            // If user asked to remove file
            if ($request->has('remove_file') && $request->remove_file) {
                if ($expenseCategory->opening_balance_sheet) {
                    Storage::disk('public')->delete($expenseCategory->opening_balance_sheet);
                    $expenseCategory->opening_balance_sheet = null; // Clear DB field
                }
            }

            // If a new file was uploaded
            $openingBalanceSheetPath = null;
            if ($request->hasFile('opening_balance_sheet')) {

                if ($expenseCategory->opening_balance_sheet) {
                    Storage::disk('public')->delete($expenseCategory->opening_balance_sheet);
                }
                $file = $request->file('opening_balance_sheet');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $openingBalanceSheetPath = $file->storeAs('uploads/expense_categories', $filename, 'public');
                $expenseCategory->opening_balance_sheet = $openingBalanceSheetPath;
            }
            $expenseCategory->note = $request->note;
            $expenseCategory->status = $request->status === 'Enabled' ? 'Enabled' : 'Disabled';

            $expenseCategory->save();

            return response()->json(['status' => 'success', 'message' => 'Expense category updated successfully']);
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
            $expenseCategory = ExpenseCategory::findOrFail($id);
            $expenseCategory->delete();
            return response()->json(['status' => 'success', 'message' => 'Expense category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
