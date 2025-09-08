<?php

namespace App\Models;
use App\Models\Admin\MyOffice\Branch;
use App\Models\Business\Company;
use Illuminate\Database\Eloquent\Model;

class MikrotikDevice extends Model
{
        protected $fillable =
    [
        'company_id',
        'branch_id', 
        'host', 
        'user',
        'password',
        'port', 
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
}
