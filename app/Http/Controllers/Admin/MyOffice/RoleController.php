<?php

namespace App\Http\Controllers\Admin\MyOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = ModelsRole::where('company_id', $user->company_id)
                          ->get();
        return view('backend.pages.myoffice.role', compact('roles'));
    }

    public function activeIndex()
    {
        $user = Auth::user();
        $roles = ModelsRole::where('company_id', $user->company_id)->where('status', 1)->get();
        return response()->json($roles);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'           => 'required|string|max:255|unique:roles,name',
                'code'           => 'required|string|max:255|unique:roles,code',
                'note'           => 'nullable|string|max:2000',
                'status'         => 'required|in:1,0',
            ]);
    
            $user = Auth::user();
            ModelsRole::create([
                'company_id'     => $user->company_id,
                'name'           => $request->name,
                'code'           => $request->code,
                'note'           => $request->note,
                'user_id'        => $user->id,
                'status'         => $request->status
            ]);
    
            return response()->json(['status' => 'success','message' => 'Role added successfully']);
    
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
        $roles = ModelsRole::findOrFail($id);
        return response()->json($roles);
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
        $Role = ModelsRole::findOrFail($id);
    
        $Role->name           = $request->name;
        $Role->code           = $request->code;
        $Role->note           = $request->note;
        $Role->status         = $request->status ? 1 : 0;
        $Role->user_id        = $user->id;
        $Role->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Role updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $roles = ModelsRole::findOrFail($id);
            $roles->delete();
            return response()->json(['status' => 'success', 'message' => 'roles deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
