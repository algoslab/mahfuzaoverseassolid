<?php

namespace App\Http\Controllers\Supper_Admin\service;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\service\HazzUmrah;
use Illuminate\Http\Request;

class HazzUmrahcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hazzUmrah = HazzUmrah::where('status', 1)->get();
        return view('supper_admin.pages.service.hazz&umrah', compact('hazzUmrah'));
    }

    public function Activeindex()
    {
        $hazzUmrahs = HazzUmrah::where('status', 1)->get();
        return response()->json($hazzUmrahs);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // return $request->all();
        $validated = $request->validate([
            'flight_date'           => 'nullable|date',
            'services'              => 'required|string|max:255',
            'packages'              => 'nullable|string|max:255',
            'transit'               => 'nullable|string|max:255',
            'hotel_category'        => 'nullable|string|max:255',
            'mokka_modina_transport'=> 'nullable|string|max:255',
            'meal'                  => 'nullable|string|max:255',
            'days'                  => 'nullable|string|max:255',
            'amount_b2c'            => 'nullable|string|max:255',
            'amount_b2B'            => 'nullable|string|max:255',
            'status'                => 'nullable|boolean',
        ]);

        HazzUmrah::create([
            'flight_date'           => $validated['flight_date'],
            'services'              => $validated['services'],
            'packages'              => $validated['packages'],
            'transit'               => $validated['transit'],
            'hotel_category'        => $validated['hotel_category'],
            'mokka_modina_transport'=> $validated['mokka_modina_transport'] ?? null,
            'meal'                  => $validated['meal'] ?? null,
            'days'                  => $validated['days'] ?? null,
            'amount_b2c'            => $validated['amount_b2c'] ?? null,
            'amount_b2B'            => $validated['amount_b2B'] ?? null,
            'status'                => $validated['status'] ?? 0, 
        ]);
        return redirect()->back()->with(['status' => 'success', 'message' => 'Hazz Or Umrah added successfully!']);
    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy($id)
    {
        $hazzUmrah = HazzUmrah::findOrFail($id);
        $hazzUmrah->delete();
        return redirect()->route('supper_admin.hazz-umrah.index')->with(['status'=>'success',  'message'=>'Hazz Or Umrah Delete successfully!']);
    }
}
