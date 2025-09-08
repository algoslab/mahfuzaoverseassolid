<?php

namespace App\Http\Controllers\Supper_Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Location\Continent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ContinentController extends Controller
{

    public function index()
    {
        $continents = Continent::get();
        return view('supper_admin.pages.location.continent', compact('continents'));
    }

    public function Activeindex()
    {
        $continents = Continent::where('status', 'Active')->get();
        return response()->json($continents);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'code'      => 'required|string|max:255',
                'name'      => 'required|string|max:255',
                'status'    => 'required|in:Active,Inactive'
            ]);

            $user_id = Auth::id();
            $continent = Continent::create([
                'code'      => $request->input('code'),
                'name'      => $request->input('name'),
                'user_id'   => $user_id,
                'status'    => $request->input('status')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Continent added Successfully']);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->validator->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $continent = Continent::findOrFail($id);
        return response()->json($continent);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $continent = Continent::findOrFail($id);
        $continent->name = $request->name;
        $continent->code = $request->code;
        $continent->status = $request->status ? 'Active' : 'Inactive';
        
        $continent->save();
    
        return response()->json(['status' => 'success', 'message' => 'Continent updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $continent = Continent::findOrFail($id);
            $continent->delete();
            return response()->json(['status' => 'success', 'message' => 'Continent deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
