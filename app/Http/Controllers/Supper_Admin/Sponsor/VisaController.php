<?php

namespace App\Http\Controllers\Supper_Admin\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Sponsor\Sponsor;
use App\Models\Supper_Admin\Sponsor\Visa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class VisaController extends Controller
{
    public function index()
    {
        $visas = Visa::get();
        return view('supper_admin.pages.sponsor.visa', compact('visas'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'sponsor_id'      => 'required|integer',
                'job_list_id'      => 'required|integer',
                'country_id'      => 'required|integer',
                'currency'      => 'required',
                'age_from'      => 'required',
                'age_to'      => 'required',
                'visa_qty'      => 'required',
                'bdt_price'      => 'nullable',
                'gender'    => 'required|in:Male,Female,Haji',
                'demand_letter' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
                'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $demandLetterPath = null;
            $attachmentPath = null;

            if ($request->hasFile('demand_letter')) {
                $file = $request->file('demand_letter');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $demandLetterPath = $file->storeAs('uploads/visas', $filename, 'public');
            }

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $attachmentPath = $file->storeAs('uploads/visas', $filename, 'public');
            }

            Visa::create([
                'sponsor_id'      => $request->input('sponsor_id'),
                'job_list_id'  => $request->input('job_list_id'),
                'country_id'  => $request->input('country_id'),
                'issue_date'  => $request->input('issue_date'),
                'age_from'  => $request->input('age_from'),
                'age_to'  => $request->input('age_to'),
                'visa_number'  => $request->input('visa_number'),
                'visa_qty'  => $request->input('visa_qty'),
                'type'  => $request->input('type'),
                'gender'  => $request->input('gender'),
                'currency'  => $request->input('currency'),
                'monthly_salary'  => $request->input('monthly_salary'),
                'salary_bdt_amount'  => $request->input('bdt_price')*$request->input('monthly_salary'),
                'purchase_amount'  => $request->input('purchase_amount'),
                'purchase_bdt_amount'  => $request->input('bdt_price')*$request->input('purchase_amount'),
                'agent_price'  => $request->input('agent_price'),
                'agent_bdt_price'  => $request->input('bdt_price')*$request->input('agent_price'),
                'candidate_price'  => $request->input('candidate_price'),
                'candidate_bdt_price'  => $request->input('bdt_price')*$request->input('candidate_price'),
                'commission_amount'  => $request->input('commission_amount'),
                'commission_bdt_amount'  => $request->input('bdt_price')*$request->input('commission_amount'),
                'demand_letter'         => $demandLetterPath,
                'attachment'         => $attachmentPath,
                'note'  => $request->input('note'),
                'provide_food'    => $request->input('provide_food') === '1' ? '1' : '0',
                'provide_accommodation'    => $request->input('provide_accommodation') === '1' ? '1' : '0',
                'status'    => $request->input('status') === 'Enabled' ? 'Enabled' : 'Disabled'
            ]);
            return response()->json(['status' => 'success', 'message' => 'Visa added Successfully']);
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
        $visa = Visa::findOrFail($id);
        return response()->json($visa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'sponsor_id'      => 'required|integer',
                'job_list_id'      => 'required|integer',
                'country_id'      => 'required|integer',
                'currency'      => 'required',
                'age_from'      => 'required',
                'age_to'      => 'required',
                'bdt_price'      => 'nullable',
                'visa_qty'      => 'required',
               'gender'    => 'required|in:Male,Female,Haji',
                'demand_letter' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
                'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $visa = Visa::findOrFail($id);
            $visa->sponsor_id = $request->sponsor_id;
            $visa->job_list_id = $request->job_list_id;
            $visa->country_id = $request->country_id;
            $visa->issue_date = $request->issue_date;
            $visa->age_from = $request->age_from;
            $visa->age_to = $request->age_to;
            $visa->visa_number = $request->visa_number;
            $visa->visa_qty = $request->visa_qty;
            $visa->type = $request->type;
            $visa->gender = $request->gender;
            $visa->currency = $request->currency;
            $visa->monthly_salary = $request->monthly_salary;
            $visa->salary_bdt_amount = $request->monthly_salary * $request->bdt_price;
            $visa->purchase_amount = $request->purchase_amount;
            $visa->purchase_bdt_amount = $request->purchase_amount * $request->bdt_price;
            $visa->payment_type = $request->payment_type;
            $visa->agent_price = $request->agent_price;
            $visa->agent_bdt_price = $request->agent_price * $request->bdt_price;
            $visa->candidate_price = $request->candidate_price;
            $visa->candidate_bdt_price = $request->candidate_price * $request->bdt_price;
            $visa->commission_amount = $request->commission_amount;
            $visa->commission_bdt_amount = $request->bdt_price * $request->commission_amount;

            // If user asked to remove file
            if ($request->has('remove_file1') && $request->remove_file1) {
                if ($visa->demand_letter) {
                    Storage::disk('public')->delete($visa->demand_letter);
                    $visa->demand_letter = null; // Clear DB field
                }
            }

            // If a new file was uploaded
            if ($request->hasFile('demand_letter')) {

                if ($visa->demand_letter) {
                    Storage::disk('public')->delete($visa->demand_letter);
                }
                $file = $request->file('demand_letter');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $demandLetterPath = $file->storeAs('uploads/visas', $filename, 'public');
                $visa->demand_letter = $demandLetterPath;
            }

            // If user asked to remove file
            if ($request->has('remove_file') && $request->remove_file) {
                if ($visa->attachment) {
                    Storage::disk('public')->delete($visa->attachment);
                    $visa->attachment = null; // Clear DB field
                }
            }

            // If a new file was uploaded
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {

                if ($visa->sponsor_photo) {
                    Storage::disk('public')->delete($visa->attachment);
                }
                $file = $request->file('attachment');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $attachmentPath = $file->storeAs('uploads/visas', $filename, 'public');
                $visa->attachment = $attachmentPath;
            }

            $visa->note = $request->note;
            $visa->provide_food = $request->provide_food === '1' ? '1' : '0';
            $visa->provide_accommodation = $request->provide_accommodation === '1' ? '1' : '0';
            $visa->status = $request->status === 'Enabled' ? 'Enabled' : 'Disabled';

            $visa->save();

            return response()->json(['status' => 'success', 'message' => 'Visa updated successfully']);
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
            $visa = Visa::findOrFail($id);
            $visa->delete();
            return response()->json(['status' => 'success', 'message' => 'Visa deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
