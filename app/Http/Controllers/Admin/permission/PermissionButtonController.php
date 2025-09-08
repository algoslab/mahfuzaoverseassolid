<?php

namespace App\Http\Controllers\Admin\permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;

class PermissionButtonController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $permissionButtions = Permission::all();
        return view('backend.pages.permission.button', compact('permissionButtions'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'           => 'required|string|max:255|unique:permissions,name',
            ]);
    
            $user = Auth::user();
            Permission::create([
                'name'           => $request->name,
            ]);
    
            return response()->json(['status' => 'success','message' => 'Permission added successfully']);
    
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
        $permissionButtions = Permission::findOrFail($id);
        return response()->json($permissionButtions);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
        ]);
        $user = Auth::user();
        $Permission = Permission::findOrFail($id);
    
        $Permission->name           = $request->name;
        $Permission->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Permission updated successfully',
        ]);
    }
    

    public function destroy(string $id)
    {
        try {
            $permissionButtions = Permission::findOrFail($id);
            $permissionButtions->delete();
            return response()->json(['status' => 'success', 'message' => 'Button deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
