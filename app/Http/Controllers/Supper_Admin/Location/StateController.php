<?php

namespace App\Http\Controllers\Supper_Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Location\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class StateController extends Controller
{
    public function index()
    {
        $states = State::get();
        return view('supper_admin.pages.location.state', compact('states'));
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
                'code'          => 'nullable|string|max:255',
                'country_id'    => 'required|exists:countries,id',
                'status'        => 'required|in:Active,Inactive'
            ]);

            $user_id = Auth::id();
            State::create([
                'name'          => $request->input('name'),
                'code'          => $request->input('code'),
                'country_id'    => $request->input('country_id'),
                'user_id'       => $user_id,
                'status'        => $request->input('status')
            ]);
            return response()->json(['status' => 'success', 'message' => 'state added Successfully']);
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
        $states = State::findOrFail($id);
        return response()->json($states);
    }

    public function update(Request $request, string $id)
    {
        $states = State::findOrFail($id);
        $states->name        = $request->name;
        $states->code        = $request->code;
        $states->country_id  = $request->country_id;
        $states->status      = $request->status ? 'Active' : 'Inactive';
        $states->save();
        return response()->json(['status' => 'success', 'message' => 'states updated successfully']);
    }

    public function destroy(string $id)
    {
        try {
            $states = State::findOrFail($id);
            $states->delete();
            return response()->json(['status' => 'success', 'message' => 'states deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
