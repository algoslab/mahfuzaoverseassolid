<?php

namespace App\Models\Supper_Admin\Location;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    protected $fillable =
    [
        'name', 
        'code', 
        'status',
        'district_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
