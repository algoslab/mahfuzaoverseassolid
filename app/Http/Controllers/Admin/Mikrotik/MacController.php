<?php

namespace App\Http\Controllers\Admin\Mikrotik;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mikrotik\MacAddress;
use App\Models\MikrotikDevice;
use Illuminate\Http\Request;
use App\Services\MikroTikService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MacController extends Controller
{
    protected $mikroTik;

    public function __construct(MikroTikService $mikroTikService)
    {
        $this->mikroTik = $mikroTikService;
    }
    
    public function index()
    {
        $user = Auth::user();
        $macaddress = MacAddress::where('company_id', $user->company_id)->where('status', 1)->get();
        return view('backend.pages.mikrotik.mac-address', compact('macaddress'));
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
                'mac_address'        => 'nullable|string',
                'ip_address'         => 'nullable|string',
                'type'               => 'required|string',
                'status'             => 'nullable|in:1,0'
            ]);
            $user = Auth::user();
            $macaddress = $request->input('mac_address');
            $ipaddress = $request->input('ip_address');
            $type = $request->input('type', 'bypassed');

            if ($macaddress && MacAddress::where('mac_address', $macaddress)->exists()) {
                return response()->json(['status' => 'fail', 'message' => 'MAC address already exists']);
            }

            // Check if IP address exists only if provided
            if ($ipaddress && MacAddress::where('ip_address', $ipaddress)->exists()) {
                return response()->json(['status' => 'fail', 'message' => 'IP address already exists']);
            }

            $device = MikrotikDevice::findOrFail($request->mikrotik_device_id);

            // ✅ Connect to the Mikrotik router first
            $this->mikroTik->connect([
                'host'     => $device->host,
                'user'     => $device->user,
                'password' => $device->password,
                'port'     => $device->port,
            ]);
            $this->mikroTik->createMacAddress($macaddress, $ipaddress,  $type);

            // return $this->mikroTik;
            MacAddress::create([
                'branch_id'             => $request->input('branch_id'),
                'mikrotik_device_id'    => $request->input('mikrotik_device_id'),
                'mac_address'           => $request->input('mac_address'),
                'ip_address'            => $request->input('ip_address'),
                'type'                  => $request->input('type'),
                'status'                => $request->input('status'),
                'user_id'               => $user->id,
                'company_id'            => $user->company_id,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Mac Address user added Successfully']);
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
            $macAddress = MacAddress::findOrFail($id);
            $device = MikrotikDevice::findOrFail($macAddress->mikrotik_device_id);
            $this->mikroTik->connect([
                'host'     => $device->host,
                'user'     => $device->user,
                'password' => $device->password,
                'port'     => $device->port,
            ]);

            // Call delete method with both MAC and IP (pass null if not available)
            $this->mikroTik->deleteBinding(
                $macAddress->mac_address ?? null,
                $macAddress->ip_address ?? null
            );

            $macAddress->delete();
            return response()->json(['status' => 'success', 'message' => 'Binding user deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

}
