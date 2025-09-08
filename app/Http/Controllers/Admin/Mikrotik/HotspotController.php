<?php

namespace App\Http\Controllers\Admin\Mikrotik;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mikrotik\Hotspot;
use App\Models\MikrotikDevice;
use Illuminate\Http\Request;
use App\Services\MikroTikService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HotspotController extends Controller
{
    protected $mikroTik;

    public function __construct(MikroTikService $mikroTikService)
    {
        $this->mikroTik = $mikroTikService;
    }
    
    public function index()
    {
        $user = Auth::user();
        $hotspots = Hotspot::where('company_id', $user->company_id)->where('status', 1)->get();
        return view('backend.pages.mikrotik.hotspot', compact('hotspots'));
    }



    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'branch_id'          => 'required|exists:branches,id',
                'mikrotik_device_id' => 'required|exists:mikrotik_devices,id',
                'username'           => 'required|string',
                'password'           => 'required|string',
                'profile'            => 'nullable|string',
                'status'             => 'nullable|in:1,0'
            ]);
            $user = Auth::user();
                // Call MikroTik API to create hotspot user
            $username = $request->input('username');
            $password = $request->input('password');
            $profile = $request->input('profile', 'default');

            $device = MikrotikDevice::findOrFail($request->mikrotik_device_id);

            // ✅ Connect to the Mikrotik router first
            $this->mikroTik->connect([
                'host'     => $device->host,
                'user'     => $device->user,
                'password' => $device->password,
                'port'     => $device->port,
            ]);
            $this->mikroTik->createHotspotUser($username, $password, $profile);
            Hotspot::create([
                'branch_id'             => $request->input('branch_id'),
                'mikrotik_device_id'    => $request->input('mikrotik_device_id'),
                'username'              => $request->input('username'),
                'password'              => $request->input('password'),
                'profile'               => $request->input('profile'),
                'status'                => $request->input('status'),
                'user_id'               => $user->id,
                'company_id'            => $user->company_id,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Hotspot user added Successfully']);
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
            $hotspot = Hotspot::findOrFail($id);
            $device = MikrotikDevice::findOrFail($hotspot->mikrotik_device_id);
            $this->mikroTik->connect([
                'host'     => $device->host,
                'user'     => $device->user,
                'password' => $device->password,
                'port'     => $device->port,
            ]);
            $this->mikroTik->deleteHotspotUser($hotspot->username);
            $hotspot->delete();
            return response()->json(['status' => 'success', 'message' => 'Hotspot user deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

}
