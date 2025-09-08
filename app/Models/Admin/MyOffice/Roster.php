<?php

namespace App\Models\Admin\MyOffice;

use App\Models\Business\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $fillable =
    [
        'company_id',
        'name', 
        'code',
        'duty_hours',
        'start_time',
        'end_time',
        'meal_break',
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
