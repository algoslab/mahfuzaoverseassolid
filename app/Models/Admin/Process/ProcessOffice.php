<?php

namespace App\Models\Admin\Process;
use App\Models\Business\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProcessOffice extends Model
{
    protected $fillable =
    [
        'company_id',
        'name', 
        'license_number',
        'phone_number',
        'email',
        'opening_balance',
        'address',
        'office_pad',
        'opening_balance_sheet',
        'note',
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
}
