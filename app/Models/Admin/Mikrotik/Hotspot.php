<?php

namespace App\Models\Admin\Mikrotik;

use App\Models\Admin\MyOffice\Branch;
use App\Models\Business\Company;
use App\Models\MikrotikDevice;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model
{
    protected $fillable =
    [
        'company_id',
        'branch_id',
        'mikrotik_device_id', 
        'username', 
        'password',
        'profile',
        'status', 
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function router()
    {
        return $this->belongsTo(MikrotikDevice::class, 'mikrotik_device_id');
    }
}
