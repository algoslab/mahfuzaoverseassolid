<?php

namespace App\Http\Controllers\Supper_Admin\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Sponsor\MarketingVisa;
use App\Models\Supper_Admin\Sponsor\Visa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class MarketingVisaController extends Controller
{
    public function index()
    {
        $visas = MarketingVisa::get();
        return view('supper_admin.pages.sponsor.marketing-visa', compact('visas'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'job_list_id'      => 'required|integer',
                'country_id'      => 'required|integer',
                'salary_currency_id'      => 'required|integer',
                'cost_currency_id'      => 'required|integer',
                'type'    => 'required|in:Air Ticket,Business Visa,Hazz & Umrah,Manpower,Patient,Tourist,Visa Processing,Worker',
                'gender'    => 'required|in:Male,Female',
                'monthly_salary'      => 'required',
                'cost'      => 'required',
                'available_qty'      => 'required',
                'registration_fee'      => 'required',
                'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $attachmentPath = null;

            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('marketing_visas', 'public');
            }

            MarketingVisa::create([
                'job_list_id'  => $request->input('job_list_id'),
                'country_id'  => $request->input('country_id'),
                'type'  => $request->input('type'),
                'gender'  => $request->input('gender'),
                'salary_currency_id'  => $request->input('salary_currency_id'),
                'monthly_salary'  => $request->input('monthly_salary'),
                'cost_currency_id'  => $request->input('cost_currency_id'),
                'cost'  => $request->input('cost'),
                'available_qty'  => $request->input('available_qty'),
                'registration_fee'  => $request->input('registration_fee'),
                'attachment'         => $attachmentPath,
                'note'  => $request->input('note'),
                'send_sms_to_agent'    => $request->input('send_sms_to_agent') === '1' ? '1' : '0',
                'status'    => $request->input('status') === 'Enabled' ? 'Enabled' : 'Disabled'
            ]);
            return response()->json(['status' => 'success', 'message' => 'Marketing Visa added Successfully']);
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
        $visa = MarketingVisa::findOrFail($id);
        return response()->json($visa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'job_list_id'      => 'required|integer',
                'country_id'      => 'required|integer',
                'salary_currency_id'      => 'required|integer',
                'cost_currency_id'      => 'required|integer',
                'type'    => 'required|in:Air Ticket,Business Visa,Hazz & Umrah,Manpower,Patient,Tourist,Visa Processing,Worker',
                'gender'    => 'required|in:Male,Female,Haji',
                'monthly_salary'      => 'required',
                'cost'      => 'required',
                'available_qty'      => 'required',
                'registration_fee'      => 'required',
                'attachment' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
                'status'    => 'required|in:Enabled,Disabled'
            ]);

            $visa = MarketingVisa::findOrFail($id);
            $visa->job_list_id = $request->job_list_id;
            $visa->country_id = $request->country_id;
            $visa->type = $request->type;
            $visa->gender = $request->gender;
            $visa->salary_currency_id = $request->salary_currency_id;
            $visa->monthly_salary = $request->monthly_salary;
            $visa->cost_currency_id = $request->cost_currency_id;
            $visa->cost = $request->cost;
            $visa->available_qty = $request->available_qty;
            $visa->registration_fee = $request->registration_fee;

            // If user asked to remove file
            if ($request->has('remove_file') && $request->remove_file) {
                if ($visa->attachment) {
                    Storage::disk('public')->delete($visa->attachment);
                }
            }

            // If a new file was uploaded
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {

                if ($visa->sponsor_photo) {
                    Storage::disk('public')->delete($visa->attachment);
                }
                $attachmentPath = $request->file('attachment')->store('marketing_visas', 'public');
            }

            $visa->attachment = $attachmentPath;
            $visa->note = $request->note;
            $visa->send_sms_to_agent = $request->send_sms_to_agent === '1' ? '1' : '0';
            $visa->status = $request->status === 'Enabled' ? 'Enabled' : 'Disabled';

            $visa->save();

            return response()->json(['status' => 'success', 'message' => 'Marketing Visa updated successfully']);
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
            $visa = MarketingVisa::findOrFail($id);
            $visa->delete();
            return response()->json(['status' => 'success', 'message' => 'Marketing Visa deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
