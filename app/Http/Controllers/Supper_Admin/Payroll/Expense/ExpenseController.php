<?php

namespace App\Http\Controllers\Supper_Admin\Payroll\Expense;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Payroll\Expense\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::get();
        return view('supper_admin.pages.payroll.expense.expense', compact('expenses'));
    }

    public function Activeindex()
    {
        $expenses = Expense::where('status', 'Active')->get();
        return response()->json($expenses);
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
                'expense_item_id'      => 'required|integer',
                'payment_method'    => 'required|in:Bank Account,Cash in Hand,Mobile Banking,Office Assets',
                'currency'      => 'required',
                'amount'      => 'required',
                'bdt_amount'      => 'required',
                'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240' // 10MB max
            ]);

            $attachmentPath = null;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $attachmentPath = $file->storeAs('uploads/expenses', $filename, 'public');
            }

            Expense::create([
                'expense_category_id'      => $request->input('expense_category_id'),
                'expense_item_id'      => $request->input('expense_item_id'),
                'payment_method'      => $request->input('payment_method'),
                'currency'      => $request->input('currency'),
                'amount'      => $request->input('amount'),
                'bdt_amount'      => $request->input('bdt_amount'),
                'attachment'         => $attachmentPath,
                'month_year'  => $request->input('month_year'),
                'expiry_date'  => $request->input('expiry_date'),
                'transaction_note'  => $request->input('transaction_note'),
                'note'  => $request->input('note'),
            ]);
            return response()->json(['status' => 'success', 'message' => 'Expense added Successfully']);
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
        $expense = Expense::with(['expenseCategory', 'expenseItem'])->findOrFail($id);
        return response()->json($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'expense_category_id'      => 'required|integer',
                'expense_item_id'      => 'required|integer',
                'payment_method'    => 'required|in:Bank Account,Cash in Hand,Mobile Banking,Office Assets',
                'currency'      => 'required',
                'amount'      => 'required',
                'bdt_amount'      => 'required',
                'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240' // 10MB max
            ]);

            $expense = Expense::findOrFail($id);
            $expense->expense_category_id = $request->expense_category_id;
            $expense->expense_item_id = $request->expense_item_id;
            $expense->payment_method = $request->payment_method;
            $expense->currency = $request->currency;
            $expense->amount = $request->amount;
            $expense->bdt_amount = $request->bdt_amount;

            // If user asked to remove file
            if ($request->has('remove_file') && $request->remove_file) {
                if ($expense->attachment) {
                    Storage::disk('public')->delete($expense->attachment);
                    $expense->attachment = null; // Clear DB field
                }
            }

            // If a new file was uploaded
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {

                if ($expense->attachment) {
                    Storage::disk('public')->delete($expense->attachment);
                }
                $file = $request->file('attachment');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $attachmentPath = $file->storeAs('uploads/expenses', $filename, 'public');
                $expense->attachment = $attachmentPath;
            }
            $expense->month_year = $request->month_year;
            $expense->expiry_date = $request->expiry_date;
            $expense->transaction_note = $request->transaction_note;
            $expense->note = $request->note;
            $expense->save();
            return response()->json(['status' => 'success', 'message' => 'Expense updated successfully']);
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
            $expense = Expense::findOrFail($id);
            $expense->delete();
            return response()->json(['status' => 'success', 'message' => 'Expense deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
