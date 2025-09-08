<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;


class MikroTikService
{
    protected $client;

    // public function __construct()
    // {
    //     $this->client = new Client([
    //         'host' => env('MIKROTIK_HOST'),
    //         'user' => env('MIKROTIK_USER'),
    //         'pass' => env('MIKROTIK_PASSWORD'),
    //         'port' => (int) env('MIKROTIK_PORT', 8728),
    //         'timeout' => 5,
    //         'attempts' => 1,
    //     ]);
    // }

    public function connect(array $config)
    {
        if (
            empty($config['host']) ||
            empty($config['user']) ||
            empty($config['password']) ||
            empty($config['port'])
        ) {
            throw new \InvalidArgumentException("Missing MikroTik connection configuration.");
        }

        $this->client = new Client([
            'host' => $config['host'],
            'user' => $config['user'],
            'pass' => $config['password'],
            'port' => $config['port'],
        ]);
    }

    public function disconnect()
    {
        if ($this->client !== null) {
            $this->client = null;
        }
    }

    public function getInterfaces(): array
    {
        $query = new Query('/interface/print');
        return $this->client->query($query)->read();
    }

    public function sendCommand(string $command, array $arguments = []): array
    {
        $query = new Query($command);

        foreach ($arguments as $key => $value) {
            $query->equal($key, $value);
        }

        return $this->client->query($query)->read();
    }


    public function createHotspotUser(string $username, string $password, string $profile = 'default')
    {
        try {
            $query = new Query('/ip/hotspot/user/add');
            $query->equal('name', $username);
            $query->equal('password', $password);
            $query->equal('profile', $profile); 
            $response = $this->client->query($query)->read();
            return $response; 
        } catch (\Exception $e) {
            throw new \Exception("Failed to create hotspot user: " . $e->getMessage());
        }
    }

    public function createMacAddress(?string $macAddress, ?string $ipAddress, string $type = 'bypassed')
    {
        if (!$this->client) {
            throw new \Exception('MikroTik connection not established');
        }
        if (empty($macAddress) && empty($ipAddress)) {
            throw new \InvalidArgumentException('Either MAC address or IP address must be provided.');
        }
        $bindingType = $type === 'bypassed' ? 'bypassed' : 'regular';
        $existingBindings = $this->client->query(new Query('/ip/hotspot/ip-binding/print'))->read();
        $alreadyExists = collect($existingBindings)->contains(function ($item) use ($macAddress, $ipAddress) {
            return (!empty($macAddress) && isset($item['mac-address']) && $item['mac-address'] === $macAddress) ||
                (!empty($ipAddress) && isset($item['address']) && $item['address'] === $ipAddress);
        });

        if ($alreadyExists) {
            \Log::warning('MAC or IP already exists in MikroTik', [
                'mac' => $macAddress,
                'ip' => $ipAddress
            ]);
            return;
        }
        $query = new Query('/ip/hotspot/ip-binding/add');
        if (!empty($macAddress)) {
            $query->equal('mac-address', $macAddress);
        }
        if (!empty($ipAddress)) {
            $query->equal('address', $ipAddress);
        }
        $query->equal('type', $bindingType);
         try {
            $response = $this->client->query($query)->read();
            \Log::info('MikroTik add binding response', ['response' => $response]);
        } catch (\Exception $e) {
            \Log::error('MikroTik API error: ' . $e->getMessage());
            throw $e;
        }
    }





    public function deleteHotspotUser($username)
    {
        if (!$this->client) {
            throw new \Exception("Not connected to MikroTik");
        }
        $query = (new Query('/ip/hotspot/user/print'))
                    ->where('name', $username);
        $users = $this->client->query($query)->read();
        if (!empty($users)) {
            $userId = $users[0]['.id'];

            $deleteQuery = (new Query('/ip/hotspot/user/remove'))
                            ->equal('.id', $userId);
            $this->client->query($deleteQuery)->read();
        } else {
            throw new \Exception("Hotspot user not found on MikroTik device.");
        }
    }

    public function deleteBinding(?string $macAddress = null, ?string $ipAddress = null)
    {
        if (!$this->client) {
            throw new \Exception('MikroTik connection not established');
        }
        $bindings = $this->client->query(new Query('/ip/hotspot/ip-binding/print'))->read();
        $matched = collect($bindings)->first(function ($item) use ($macAddress, $ipAddress) {
            return ($macAddress && isset($item['mac-address']) && $item['mac-address'] === $macAddress)
                || ($ipAddress && isset($item['address']) && $item['address'] === $ipAddress);
        });

        if (!$matched || !isset($matched['.id'])) {
            throw new \Exception('No matching MAC or IP found in Hotspot IP Binding.');
        }
        $deleteQuery = (new Query('/ip/hotspot/ip-binding/remove'))
            ->equal('.id', $matched['.id']);

        $this->client->query($deleteQuery)->read();
        \Log::info('Deleted MikroTik IP binding', [
            'mac' => $macAddress,
            'ip'  => $ipAddress,
            'id'  => $matched['.id']
        ]);
    }



}
