<?php

namespace App\Http\Controllers\Admin\MyOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\MyOffice\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DesignationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $designations = Designation::where('user_id', $user->id)
                          ->where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.myoffice.designation', compact('designations'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $designations = Designation::where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($designations);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'           => 'required|string|max:255|unique:designations,name',
                'code'           => 'required|string|max:255|unique:designations,code',
                'note'           => 'nullable|string|max:2000',
                'status'         => 'required|in:1,0'
            ]);
    
            $user = Auth::user();
            Designation::create([
                'company_id'     => $user->company_id,
                'name'           => $request->name,
                'code'           => $request->code,
                'note'           => $request->note,
                'user_id'        => $user->id,
                'status'         => $request->status
            ]);
    
            return response()->json(['status' => 'success','message' => 'Designation added successfully']);
    
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
        $designations = Designation::findOrFail($id);
        return response()->json($designations);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'nullable|string|max:255',
            'note'           => 'nullable|string|max:2000',
            'status'         => 'required|in:1,0'
        ]);
        $user = Auth::user();
        $Designation = Designation::findOrFail($id);
    
        $Designation->name           = $request->name;
        $Designation->code           = $request->code;
        $Designation->note           = $request->note;
        $Designation->status         = $request->status ? 1 : 0;
        $Designation->user_id        = $user->id;
        $Designation->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Designation updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $designations = Designation::findOrFail($id);
            $designations->delete();
            return response()->json(['status' => 'success', 'message' => 'designations deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
