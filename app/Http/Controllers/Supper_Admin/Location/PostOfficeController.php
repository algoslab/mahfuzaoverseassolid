<?php

namespace App\Http\Controllers\Supper_Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Location\PostOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PostOfficeController extends Controller
{
    public function index()
    {
        $postoffices = PostOffice::get();
        return view('supper_admin.pages.location.post_office', compact('postoffices'));
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
            PostOffice::create([
                'name'          => $request->input('name'),
                'code'          => $request->input('code'),
                'district_id'   => $request->input('district_id'),
                'user_id'       => $user_id,
                'status'        => $request->input('status')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Post Office added Successfully']);
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
        $postoffices = PostOffice::findOrFail($id);
        return response()->json($postoffices);
    }

    public function update(Request $request, string $id)
    {
        $postoffices = PostOffice::findOrFail($id);
        $postoffices->name        = $request->name;
        $postoffices->code        = $request->code;
        $postoffices->district_id = $request->district_id;
        $postoffices->status      = $request->status ? 'Active' : 'Inactive';
        $postoffices->save();
        return response()->json(['status' => 'success', 'message' => 'postoffices updated successfully']);
    }

    public function destroy(string $id)
    {
        try {
            $postoffices = PostOffice::findOrFail($id);
            $postoffices->delete();
            return response()->json(['status' => 'success', 'message' => 'Post offices deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
