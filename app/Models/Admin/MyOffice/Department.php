<?php

namespace App\Models\Admin\MyOffice;

use App\Models\Business\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable =
    [
        'company_id',
        'name', 
        'code', 
        'include_status',
        'bonous_type', 
        'bonous_amount',
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
