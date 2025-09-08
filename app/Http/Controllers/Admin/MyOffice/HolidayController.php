<?php

namespace App\Http\Controllers\Admin\MyOffice;

use App\Http\Controllers\Controller;
use App\Models\Admin\MyOffice\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class HolidayController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $holidays = Holiday::where('user_id', $user->id)
                          ->where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.myoffice.holiday', compact('holidays'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'           => 'required|string',
                'date'           => 'required|date',
                'include_status' => 'required|in:1,0',
                'bonous_type'    => 'nullable|string|max:50',
                'bonous_amount'  => 'nullable|numeric|min:0',
                'note'           => 'nullable|string|max:2000',
                'status'         => 'required|in:1,0'
            ]);
    
            $user = Auth::user();
    
            Holiday::create([
                'company_id'     => $user->company_id,
                'name'           => $request->name,
                'date'           => $request->date,
                'include_status' => $request->include_status,
                'bonous_type'    => $request->bonous_type,
                'bonous_amount'  => $request->bonous_amount,
                'note'           => $request->note,
                'user_id'        => $user->id,
                'status'         => $request->status
            ]);
    
            return response()->json(['status' => 'success','message' => 'Holiday added successfully']);
    
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail','errors' => $e->validator->errors()], 422); 
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage()], 500);
        }
    }
    


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $holidays = Holiday::findOrFail($id);
        return response()->json($holidays);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'date'           => 'required|date',
            'include_status' => 'required|in:1,0',
            'bonous_type'    => 'nullable|string|max:50',
            'bonous_amount'  => 'nullable|numeric|min:0',
            'note'           => 'required|string|max:2000',
        ]);
        $user = Auth::user();
        $Holiday = Holiday::findOrFail($id);
    
        $Holiday->name           = $request->name;
        $Holiday->date           = $request->date;
        $Holiday->include_status = $request->include_status;
        $Holiday->note           = $request->note;
        $Holiday->status         = $request->status ? 1 : 0;
        $Holiday->user_id        = $user->id;
    
        if ($request->include_status == 1) {
            $Holiday->bonous_type   = $request->bonous_type;
            $Holiday->bonous_amount = $request->bonous_amount;
        } else {
            $Holiday->bonous_type   = null;
            $Holiday->bonous_amount = null;
        }
        $Holiday->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Holiday updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $holidays = Holiday::findOrFail($id);
            $holidays->delete();
            return response()->json(['status' => 'success', 'message' => 'Holidays deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
