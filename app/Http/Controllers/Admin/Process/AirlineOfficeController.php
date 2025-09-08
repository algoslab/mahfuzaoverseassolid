<?php

namespace App\Http\Controllers\Admin\Process;

use App\Http\Controllers\Controller;
use App\Models\Admin\Process\AirlineOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AirlineOfficeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $AirlineOffices = AirlineOffice::where('company_id', $user->company_id)->get();
        return view('backend.pages.process.airline_office', compact('AirlineOffices'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $AirlineOffices = AirlineOffice::where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($AirlineOffices);
    }
    
    public function create()
    {
        //
    }

public function store(Request $request)
{
    try {
        $request->validate([
            'name'           => 'required|string|max:255|unique:airline_offices,name',
            'phone_number'   => 'required|string|max:20',
            'email'          => 'required|email|max:255',
            'is_budget_career' => 'nullable|boolean',
            'is_IATA'        => 'nullable|boolean',
            'note'           => 'nullable|string|max:2000',
            'status'         => 'nullable|in:1,0',
        ]);

        $user = Auth::user();
        $officeType = $request->input('office_type');

        AirlineOffice::create([
            'company_id'      => $user->company_id,
            'user_id'         => $user->id,
            'name'            => $request->name,
            'phone_number'    => $request->phone_number,
            'email'           => $request->email,
            'is_budget_career'  => $officeType === 'budget' ? 1 : 0,
            'is_IATA'           => $officeType === 'iata' ? 1 : 0,
            'note'            => $request->note,
            'status'          => $request->status ?? 1,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Airline Office created successfully.',
        ]);

    } catch (ValidationException $e) {
        return response()->json([
            'status' => 'fail',
            'errors' => $e->validator->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'fail',
            'message' => $e->getMessage(),
        ], 500);
    }
}

    


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $ProcessCategory = AirlineOffice::findOrFail($id);
        return response()->json($ProcessCategory);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'note'           => 'nullable|string|max:2000',
            'status'         => 'nullable|in:1,0'
        ]);
        $user = Auth::user();
        $AirlineOffices = AirlineOffice::findOrFail($id);
        $AirlineOffices->name      = $request->name;
        $AirlineOffices->note      = $request->note;
        $AirlineOffices->status    = $request->status ? 1 : 0;
        $AirlineOffices->user_id   = $user->id;
        $AirlineOffices->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate Types updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $AirlineOfficess = AirlineOffice::findOrFail($id);
            $AirlineOfficess->delete();
            return response()->json(['status' => 'success', 'message' => 'Candidate Typess deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
