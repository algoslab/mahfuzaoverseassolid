<?php

namespace App\Models\Supper_Admin\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable =
    [
        'name', 
        'code', 
        'status',
        'country_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
