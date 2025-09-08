<?php

namespace App\Http\Controllers\Supper_Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Location\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::get();
        return view('supper_admin.pages.location.district', compact('districts'));
    }

    public function Activeindex()
    {
        $districts = District::with('division')->where('status', 'Active')->get();
        return response()->json($districts);
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
                'division_id'   => 'required|exists:divisions,id',
                'status'        => 'required|in:Active,Inactive'
            ]);

            $user_id = Auth::id();
            $districts = District::create([
                'name'          => $request->input('name'),
                'code'          => $request->input('code'),
                'division_id'   => $request->input('division_id'),
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
        $districts = District::findOrFail($id);
        return response()->json($districts);
    }

    public function update(Request $request, string $id)
    {
        $districts = District::findOrFail($id);
        $districts->name        = $request->name;
        $districts->code        = $request->code;
        $districts->division_id = $request->division_id;
        $districts->status      = $request->status ? 'Active' : 'Inactive';
        $districts->save();
        return response()->json(['status' => 'success', 'message' => 'districts updated successfully']);
    }

    public function destroy(string $id)
    {
        try {
            $districts = District::findOrFail($id);
            $districts->delete();
            return response()->json(['status' => 'success', 'message' => 'districts deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}

