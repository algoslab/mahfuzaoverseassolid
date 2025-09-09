<?php

namespace App\Http\Controllers\Supper_Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Payroll\AdvanceSalary;
use App\Models\Supper_Admin\Payroll\TravellingAndDearness;
use App\Models\Supper_Admin\Payroll\TravellingAndDearnessVehicleTypes;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TravellingAndDearnessController extends Controller
{
    public function index()
    {
        $travellingAndDearnesses = TravellingAndDearness::get();
        return view('supper_admin.pages.payroll.ta-da', compact('travellingAndDearnesses'));
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
                'from'      => 'required|string',
                'to'      => 'required|string',
                'date'      => 'required|string',
                'transport_type'    => 'required|in:One Way,Up Down',
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
                $attachmentPath = $file->storeAs('uploads/ta_da', $filename, 'public');
            }

            $travellingAndDearness = TravellingAndDearness::create([
                'department_id'      => $request->input('department_id'),
                'employee_id'      => $request->input('employee_id'),
                'from'      => $request->input('from'),
                'to'      => $request->input('to'),
                'date'      => $request->input('date'),
                'transport_type'      => $request->input('transport_type'),
                'payment_account'      => $request->input('payment_account'),
                'currency'      => $request->input('currency'),
                'amount'      => $request->input('amount'),
                'bdt_amount'      => $request->input('bdt_amount'),
                'attachment'         => $attachmentPath,
                'note'  => $request->input('note')
            ]);
            if ($request->only('vehicle_type')) {
                $data = [];
                foreach ($request->vehicle_type as $key => $row) {
                    $data[] = [
                        'travelling_and_dearness_id' => $travellingAndDearness->id,
                        'vehicle_type' => $request->vehicle_type[$key],
                        'created_at' => now(),
                    ];
                }
                TravellingAndDearnessVehicleTypes::insert($data);
            }

            return response()->json(['status' => 'success', 'message' => 'Travelling and Dareness added Successfully']);
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
            $travellingAndDearness = TravellingAndDearness::findOrFail($id);
            if(isset($travellingAndDearness->travellingAndDearnessVehicleTypes)){
                $travellingAndDearness->travellingAndDearnessVehicleTypes()->delete();
            }
            $travellingAndDearness->delete();
            return response()->json(['status' => 'success', 'message' => 'Travelling and Dareness deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
