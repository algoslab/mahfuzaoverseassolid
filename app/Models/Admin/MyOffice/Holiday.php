<?php

namespace App\Models\Admin\MyOffice;

use Illuminate\Database\Eloquent\Model;
use App\Models\Business\Company;
use App\Models\User;

class Holiday extends Model
{
    protected $fillable =
    [
        'company_id',
        'name', 
        'date', 
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
