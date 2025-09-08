<?php

namespace App\Http\Controllers\Supper_Admin\service;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\service\WorkPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class WorkPermitcontroller extends Controller
{
    public function index()
    {
        $workpermits = WorkPermit::get();
        return view('supper_admin.pages.service.work_permit', compact('workpermits'));
    }

    public function Activeindex()
    {
        $workpermits = WorkPermit::with('continent', 'country')->where('status', 'Active')->get();
        return response()->json($workpermits);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:255',
                'code'          => 'nullable|string',
                'salary'        => 'required|numeric|min:0',
                'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'expire_date'   => 'required|date',
                'continent_id'  => 'required|exists:continents,id',
                'country_id'    => 'required|exists:countries,id',
                'status'        => 'required|in:Active,Inactive',
            ]);
    
            $user_id = Auth::id();
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('work_permits', 'public');
            }
            WorkPermit::create([
                'name'          => $request->input('name'),
                'code'          => $request->input('code'),
                'salary'        => $request->input('salary'),
                'image'         => $imagePath,
                'expire_date'   => $request->input('expire_date'),
                'continent_id'  => $request->input('continent_id'),
                'country_id'    => $request->input('country_id'),
                'user_id'       => $user_id,
                'status'        => $request->input('status'),
            ]);
            return response()->json(['status' => 'success', 'message' => 'Work Permit added Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $workpermits = WorkPermit::findOrFail($id);
        return response()->json($workpermits);
    }

    public function update(Request $request, string $id)
    {
        $workpermit = WorkPermit::findOrFail($id);
        $validated = $request->validate([
            'name'          => 'required|string',
            'code'          => 'required|string',
            'salary'        => 'required|numeric',
            'expire_date'   => 'required|date',
            'continent_id'  => 'required|integer',
            'country_id'    => 'required|integer',
            'status'        => 'required|in:Active,Inactive',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            if ($workpermit->image && \Storage::exists('public/' . $workpermit->image)) {
                \Storage::delete('public/' . $workpermit->image);
            }
    
            // Store the new image
            $imagePath = $request->file('image')->store('work_permits', 'public');
            $workpermit->image = $imagePath; 
        }
    
        // Update the other fields
        $workpermit->name           = $request->name;
        $workpermit->code           = $request->code;
        $workpermit->salary         = $request->salary;
        $workpermit->expire_date    = $request->expire_date;
        $workpermit->continent_id   = $request->continent_id;
        $workpermit->country_id     = $request->country_id;
        $workpermit->status         = $request->status;
        
        // Save the workpermit
        $workpermit->save();
    
        return response()->json(['status' => 'success', 'message' => 'Work permit updated successfully']);
    }
    

    public function destroy(string $id)
    {
        try {
            $workpermit = WorkPermit::findOrFail($id);
            if ($workpermit->image) {
                $imagePath = $workpermit->image;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $workpermit->delete();
            return response()->json(['status' => 'success', 'message' => 'workpermits deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
