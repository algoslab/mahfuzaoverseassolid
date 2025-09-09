<?php

namespace App\Models\Supper_Admin\Payroll;

use Illuminate\Database\Eloquent\Model;

class TravellingAndDearnessVehicleTypes extends Model
{
    protected $fillable =
        [
            'travelling_and_dearness_id',
            'vehicle_type'
        ];

    public function travellingAndDearness()
    {
        return $this->belongsTo(TravellingAndDearness::class, 'travelling_and_dearness_id', 'id');
    }
}
