<?php

namespace App\Http\Controllers\Supper_Admin;

use App\Http\Controllers\Controller;
use App\Services\MikroTikService;
use Illuminate\Http\Request;
use App\Models\MikrotikDevice;

class MikrotikServiceController extends Controller
{
    protected $mikroTik;

    public function __construct(MikroTikService $mikroTikService)
    {
        $this->mikroTik = $mikroTikService;
    }


    public function connectToRouter($id)
    {
        try {
            $device = MikrotikDevice::findOrFail($id);

            $this->mikroTik->connect([
                'host'      => $device->host,
                'user'      => $device->user,
                'password'  => $device->password,
                'port'      => $device->port,
            ]);

            $result = $this->mikroTik->getInterfaces();
            $device->status = 2;
            $device->save();

            return response()->json(['status' => 'success', 'message' => 'Connected from MikroTik', 'data' => $result]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function disconnectFromRouter($id)
    {
        try {

            $device = MikrotikDevice::findOrFail($id);
            $this->mikroTik->disconnect();
            $device->status = 1;
            $device->save();
            return response()->json(['status' => 'success', 'message' => 'Disconnected from MikroTik']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function checkRouterStatus(Request $request)
    {
        try {
            $routerId = $request->input('id');
            $device = $routerId
                ? MikrotikDevice::findOrFail($routerId)
                : MikrotikDevice::first();

            $this->mikroTik->connect([
                'host' => $device->host,
                'user' => $device->user,
                'password' => $device->password,
                'port' => $device->port,
            ]);

            $response = $this->mikroTik->sendCommand('/system/resource/print');
            return response()->json(['status' => 'connected', 'data' => $response]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'disconnected', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Create a new hotspot user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createHotspotUser(Request $request)
    {
        $request->validate([
            'username'  => 'required|string|max:255',
            'password'  => 'required|string|max:255',
            'profile'   => 'nullable|string|max:255',  // Optional profile field
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $profile = $request->input('profile', 'default'); // Default to 'default' profile

        try {
            // Create the hotspot user in MikroTik
            $result = $this->mikroTik->createHotspotUser($username, $password, $profile);

            // Return success response with the result from MikroTik
            return response()->json([
                'status' => 'success',
                'message' => 'Hotspot user created successfully',
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
