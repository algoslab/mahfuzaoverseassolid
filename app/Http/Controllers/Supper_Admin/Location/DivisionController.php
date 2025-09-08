<?php

namespace App\Http\Controllers\Supper_Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Location\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::get();
        return view('supper_admin.pages.location.division', compact('divisions'));
    }
    public function Activeindex()
    {
        try {
            $divisions = Division::where('status', 'Active')->get();
            return response()->json($divisions);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server Error'], 500);
        }
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
                'code'          => 'required|string|max:255',
                'country_id'    => 'required|exists:countries,id',
                'status'        => 'required|in:Active,Inactive'
            ]);

            $user_id = Auth::id();
            $divisions = Division::create([
                'name'          => $request->input('name'),
                'code'          => $request->input('code'),
                'country_id'    => $request->input('country_id'),
                'user_id'       => $user_id,
                'status'        => $request->input('status')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Division added Successfully']);
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
        $divisions = Division::findOrFail($id);
        return response()->json($divisions);
    }

    public function update(Request $request, string $id)
    {
        $divisions = Division::findOrFail($id);
        $divisions->name        = $request->name;
        $divisions->code        = $request->code;
        $divisions->country_id  = $request->country_id;
        $divisions->status      = $request->status ? 'Active' : 'Inactive';
        $divisions->save();
        return response()->json(['status' => 'success', 'message' => 'Divisions updated successfully']);
    }

    public function destroy(string $id)
    {
        try {
            $divisions = Division::findOrFail($id);
            $divisions->delete();
            return response()->json(['status' => 'success', 'message' => 'Divisions deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
