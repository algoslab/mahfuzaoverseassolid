<?php

namespace App\Models\Supper_Admin\service;

use App\Models\Supper_Admin\Location\Continent;
use App\Models\Supper_Admin\Location\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class WorkPermit extends Model
{
    protected $fillable =
    [
        'name', 
        'code', 
        'salary',
        'image',
        'expire_date',
        'continent_id',
        'country_id',
        'status',
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
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
