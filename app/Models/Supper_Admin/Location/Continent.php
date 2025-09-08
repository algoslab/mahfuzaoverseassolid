<?php

namespace App\Models\Supper_Admin\Location;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    protected $fillable =
    [
        'code', 
        'name', 
        'status', 
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
