<?php

namespace App\Models\Supper_Admin\service;

use Illuminate\Database\Eloquent\Model;

class HazzUmrah extends Model
{
    protected $fillable = [
        'flight_date',
        'services',
        'packages',
        'transit',
        'hotel_category',
        'mokka_modina_transport',
        'meal',
        'days',
        'amount_b2c',
        'amount_b2B',
        'status',
    ];
}
