<?php

namespace App\Http\Controllers\Supper_Admin\Mikrotik;

use App\Http\Controllers\Controller;
use App\Models\MikrotikDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class MikrotikDeviceController extends Controller
{
    public function index()
    {
        $routers = MikrotikDevice::all();
        return view('supper_admin.pages.microtik.router', compact('routers'));
    }

    public function Activeindex(Request $request)
    {
        $user = Auth::user();
        $branchId = $request->input('branch_id');
        if (!$branchId) {
            return response()->json(['error' => 'Please select a Branch.'], 400);
        }
        $routers = MikrotikDevice::where('branch_id', $branchId)    
                                ->where('company_id', $user->company_id)
                                ->where('status', 2)
                                ->get();

        return response()->json($routers);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'company_id'         => 'required|exists:companies,id',
                'branch_id'          => 'required|exists:branches,id',
                'host'               => 'required|string',
                'user'               => 'required|string',
                'password'           => 'required|string',
                'port'               => 'nullable|string',
                'status'             => 'required|in:1,0'
            ]);
            $user = Auth::user();
            MikrotikDevice::create([
                'company_id'      => $request->input('company_id'),
                'branch_id'       => $request->input('branch_id'),
                'host'            => $request->input('host'),
                'user'            => $request->input('user'),
                'password'        => $request->input('password'),
                'port'            => $request->input('port'),
                'status'          => $request->input('status') ? 1 : 0,
                'user_id'         => $user->id,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Mikrotik added Successfully']);
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

    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {
        try {
            $devices = MikrotikDevice::findOrFail($id);
            $devices->delete();
            return response()->json(['status' => 'success', 'message' => 'Mikrotik deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
