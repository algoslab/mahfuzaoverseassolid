<?php

namespace App\Http\Controllers\Supper_Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Location\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::get();
        return view('supper_admin.pages.location.country', compact('countries'));
    }

    public function Activeindex(Request $request)
    {
        if ($request->has('continent_id') && $request->continent_id) {
            $continentId = $request->get('continent_id');
            $countries = Country::where('status', 'Active')
                                ->where('continent_id', $continentId)
                                ->get();
        } else {
            $countries = Country::where('status', 'Active')->get();
        }
    
        return response()->json($countries);
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
                'country_code'  => 'required|string|max:255',
                'phone_code'    => 'required|string|max:255',
                'continent_id'  => 'required|exists:continents,id',
                'status'        => 'required|in:Active,Inactive'
            ]);

            $user_id = Auth::id();
            $countries = Country::create([
                'name'          => $request->input('name'),
                'country_code'  => $request->input('country_code'),
                'phone_code'    => $request->input('phone_code'),
                'continent_id'  => $request->input('continent_id'),
                'user_id'       => $user_id,
                'status'        => $request->input('status')
            ]);
            return response()->json(['status' => 'success', 'message' => 'countries added Successfully']);
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
        $countries = Country::findOrFail($id);
        return response()->json($countries);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $countries = Country::findOrFail($id);
        $countries->name            = $request->name;
        $countries->country_code    = $request->country_code;
        $countries->phone_code      = $request->phone_code;
        $countries->continent_id    = $request->continent_id;
        $countries->status          = $request->status ? 'Active' : 'Inactive';
        
        $countries->save();
    
        return response()->json(['status' => 'success', 'message' => 'countries updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $countries = Country::findOrFail($id);
            $countries->delete();
            return response()->json(['status' => 'success', 'message' => 'countries deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
