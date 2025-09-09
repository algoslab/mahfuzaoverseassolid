<?php

namespace App\Http\Controllers\Supper_Admin\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Payroll\Expense\Expense;
use App\Models\Supper_Admin\Payroll\Expense\ExpenseCategory;
use App\Models\Supper_Admin\Sponsor\Sponsor;
use App\Models\Supper_Admin\Sponsor\SponsorTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::get();
        return view('supper_admin.pages.sponsor.sponsor', compact('sponsors'));
    }

    public function enabledIndex()
    {
        $sponsors = Sponsor::where('status', 'Enabled')->get();
        return response()->json($sponsors);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'sponsor_type'    => 'required|in:Agent,Delegate,Prime Sponsor',
                'sponsor_name'      => 'required|string|max:255',
                'cell_number'      => 'required|string|max:255',
                'nid'      => 'required',
                'sponsor_photo' => 'nullable|mimes:jpg,jpeg,png|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $openingBalanceSheetPath = null;

            if ($request->hasFile('sponsor_photo')) {
                $file = $request->file('sponsor_photo');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $openingBalanceSheetPath = $file->storeAs('uploads/sponsors', $filename, 'public');
            }

            Sponsor::create([
                'user_id'               => Auth::user()->id,
                'sponsor_type'      => $request->input('sponsor_type'),
                'agent_id'  => $request->input('agent_id'),
                'delegate_id'  => $request->input('delegate_id'),
                'delegate_office_id'  => $request->input('delegate_office_id'),
                'sponsor_name'  => $request->input('sponsor_name'),
                'cell_number'  => $request->input('cell_number'),
                'email'  => $request->input('email'),
                'opening_balance'  => $request->input('opening_balance'),
                'nid'  => $request->input('nid'),
                'sponsor_photo'         => $openingBalanceSheetPath,
                'note'  => $request->input('note'),
                'address'  => $request->input('address'),
                'status'    => $request->input('status') === 'Enabled' ? 'Enabled' : 'Disabled'
            ]);
            return response()->json(['status' => 'success', 'message' => 'Sponsor added Successfully']);
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
        $sponsor = Sponsor::with(['sponsorTransactions', 'agent', 'delegate', 'user'])->findOrFail($id);
        return response()->json($sponsor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'sponsor_type'    => 'required|in:Agent,Delegate,Prime Sponsor',
                'sponsor_name'      => 'required|string|max:255',
                'cell_number'      => 'required|string|max:255',
                'nid'      => 'required',
                'sponsor_photo' => 'nullable|mimes:jpg,jpeg,png|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $sponsor = Sponsor::findOrFail($id);
            $sponsor->user_id = Auth::user()->id;
            $sponsor->sponsor_type = $request->sponsor_type;
            $sponsor->agent_id = $request->agent_id;
            $sponsor->delegate_id = $request->delegate_id;
            $sponsor->delegate_office_id = $request->delegate_office_id;
            $sponsor->sponsor_name = $request->sponsor_name;
            $sponsor->cell_number = $request->cell_number;
            $sponsor->email = $request->email;
            $sponsor->opening_balance = $request->opening_balance;
            $sponsor->nid = $request->nid;

            // If user asked to remove file
            if ($request->has('remove_file') && $request->remove_file) {
                if ($sponsor->sponsor_photo) {
                    Storage::disk('public')->delete($sponsor->sponsor_photo);
                    $sponsor->sponsor_photo = null; // Clear DB field
                }
            }

// If a new file was uploaded
            if ($request->hasFile('sponsor_photo')) {
                // Delete old file if exists
                if ($sponsor->sponsor_photo) {
                    Storage::disk('public')->delete($sponsor->sponsor_photo);
                }

                $file = $request->file('sponsor_photo');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $sponsorPhotoPath = $file->storeAs('uploads/sponsors', $filename, 'public');

                $sponsor->sponsor_photo = $sponsorPhotoPath; // Save new file path
            }
            $sponsor->address = $request->address;
            $sponsor->note = $request->note;
            $sponsor->status = $request->status === 'Enabled' ? 'Enabled' : 'Disabled';

            $sponsor->save();

            return response()->json(['status' => 'success', 'message' => 'Sponsor updated successfully']);
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
            $sponsor = Sponsor::findOrFail($id);
            $sponsor->delete();
            return response()->json(['status' => 'success', 'message' => 'Sponsor deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function makeTransaction(Request $request)
    {
        try {
            $request->validate([
                'sponsor_id'      => 'required|integer',
                'transaction_type'    => 'required|in:Received Payment,Give Payment',
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
                $attachmentPath = $file->storeAs('uploads/sponsor-transactions', $filename, 'public');
            }
            $sponsor = Sponsor::where('id', $request->input('sponsor_id'))->first();
            $sponsor->update(['balance' => $sponsor->balance + $request->input('bdt_amount')]);
            SponsorTransaction::create([
                'sponsor_id'      => $request->input('sponsor_id'),
                'transaction_type'      => $request->input('transaction_type'),
                'payment_method'      => $request->input('payment_method'),
                'currency'      => $request->input('currency'),
                'amount'      => $request->input('amount'),
                'candidate_id'      => $request->input('candidate_id'),
                'bdt_amount'      => $request->input('bdt_amount'),
                'attachment'         => $attachmentPath,
                'transaction_note'  => $request->input('transaction_note'),
                'note'  => $request->input('note'),
            ]);
            return response()->json(['status' => 'success', 'message' => 'Make transaction Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
