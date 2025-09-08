<?php

namespace App\Models\Supper_Admin\Location;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable =
    [
        'name', 
        'code', 
        'phone',
        'email',
        'picture',
        'address',
        'note',
        'status',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
