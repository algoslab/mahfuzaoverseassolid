<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;
use App\Models\Business\Company;
use App\Models\User;
class AirlineOffice extends Model
{
    protected $fillable =
    [
        'company_id',
        'name', 
        'phone_number',
        'email',
        'is_budget_career',
        'is_IATA',
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
