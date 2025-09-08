<?php

namespace App\Http\Controllers\Admin\MyOffice;

use App\Http\Controllers\Controller;
use App\Models\Admin\MyOffice\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $departments = Department::where('user_id', $user->id)
                          ->where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.myoffice.department', compact('departments'));
    }

    public function Activeindex()
    {
        $user = Auth::user();
        $departments = Department::where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($departments);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'           => 'required|string|max:255|unique:departments,name',
                'code'           => 'required|string|max:255|unique:departments,code',
                'include_status' => 'required|in:1,0',
                'bonous_type'    => 'nullable|string|max:50',
                'bonous_amount'  => 'nullable|numeric|min:0',
                'note'           => 'nullable|string|max:2000',
                'status'         => 'required|in:1,0'
            ]);
    
            $user = Auth::user();
    
            Department::create([
                'company_id'     => $user->company_id,
                'name'           => $request->name,
                'code'           => $request->code,
                'include_status' => $request->include_status,
                'bonous_type'    => $request->bonous_type,
                'bonous_amount'  => $request->bonous_amount,
                'note'           => $request->note,
                'user_id'        => $user->id,
                'status'         => $request->status
            ]);
    
            return response()->json(['status' => 'success','message' => 'Department added successfully']);
    
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
        $departments = Department::findOrFail($id);
        return response()->json($departments);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'nullable|string|max:255',
            'include_status' => 'required|in:1,0',
            'bonous_type'    => 'nullable|string|max:50',
            'bonous_amount'  => 'nullable|numeric|min:0',
            'note'           => 'required|string|max:2000',
        ]);
        $user = Auth::user();
        $department = Department::findOrFail($id);
    
        $department->name           = $request->name;
        $department->code           = $request->code;
        $department->include_status = $request->include_status;
        $department->note           = $request->note;
        $department->status         = $request->status ? 1 : 0;
        $department->user_id        = $user->id;
    
        if ($request->include_status == 1) {
            $department->bonous_type   = $request->bonous_type;
            $department->bonous_amount = $request->bonous_amount;
        } else {
            $department->bonous_type   = null;
            $department->bonous_amount = null;
        }
        $department->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Department updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $departments = Department::findOrFail($id);
            $departments->delete();
            return response()->json(['status' => 'success', 'message' => 'departments deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
