<?php

namespace App\Http\Controllers\Supper_Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Location\Thana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ThanaController extends Controller
{
    public function index()
    {
        $thanas = Thana::get();
        return view('supper_admin.pages.location.thana', compact('thanas'));
    }

    public function Activeindex()
    {
        $thanas = Thana::where('status', 'Active')->get();
        return response()->json($thanas);
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
                'district_id'   => 'required|exists:districts,id',
                'status'        => 'required|in:Active,Inactive'
            ]);

            $user_id = Auth::id();
            Thana::create([
                'name'          => $request->input('name'),
                'code'          => $request->input('code'),
                'district_id'   => $request->input('district_id'),
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
        $thanas = Thana::findOrFail($id);
        return response()->json($thanas);
    }

    public function update(Request $request, string $id)
    {
        $thanas = Thana::findOrFail($id);
        $thanas->name        = $request->name;
        $thanas->code        = $request->code;
        $thanas->district_id = $request->district_id;
        $thanas->status      = $request->status ? 'Active' : 'Inactive';
        $thanas->save();
        return response()->json(['status' => 'success', 'message' => 'thanas updated successfully']);
    }

    public function destroy(string $id)
    {
        try {
            $thanas = Thana::findOrFail($id);
            $thanas->delete();
            return response()->json(['status' => 'success', 'message' => 'thanas deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
