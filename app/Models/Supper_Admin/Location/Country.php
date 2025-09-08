<?php

namespace App\Models\Supper_Admin\Location;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable =
    [
        'name', 
        'country_code', 
        'phone_code', 
        'status',
        'continent_id',
        'user_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function continent()
    {
        return $this->belongsTo(Continent::class, 'continent_id');
    }
}
