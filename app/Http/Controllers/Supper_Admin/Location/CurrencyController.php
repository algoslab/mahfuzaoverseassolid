<?php

namespace App\Http\Controllers\Supper_Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\Location\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::get();
        return view('supper_admin.pages.location.currency', compact('currencies'));
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
                'symbol'        => 'required|string|max:3',
                'country_id'    => 'required|exists:countries,id',
                'status'        => 'required|in:Active,Inactive'
            ]);

            $user_id = Auth::id();
            Currency::create([
                'name'          => $request->input('name'),
                'code'          => $request->input('code'),
                'symbol'        => $request->input('symbol'),
                'country_id'    => $request->input('country_id'),
                'user_id'       => $user_id,
                'status'        => $request->input('status')
            ]);
            return response()->json(['status' => 'success', 'message' => 'Currency added Successfully']);
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
        $currencies = Currency::findOrFail($id);
        return response()->json($currencies);
    }

    public function update(Request $request, string $id)
    {
        $currencies = Currency::findOrFail($id);
        $currencies->name        = $request->name;
        $currencies->code        = $request->code;
        $currencies->symbol      = $request->symbol;
        $currencies->country_id  = $request->country_id;
        $currencies->status      = $request->status ? 'Active' : 'Inactive';
        $currencies->save();
        return response()->json(['status' => 'success', 'message' => 'currencies updated successfully']);
    }

    public function destroy(string $id)
    {
        try {
            $currencies = Currency::findOrFail($id);
            $currencies->delete();
            return response()->json(['status' => 'success', 'message' => 'Currencies deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
