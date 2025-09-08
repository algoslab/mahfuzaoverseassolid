<?php

namespace App\Models\Supper_Admin\service;

use App\Models\Supper_Admin\service\AirTicketFile;
use Illuminate\Database\Eloquent\Model;

class AirTicket extends Model
{
    protected $fillable = [
        'air_ticket_file_id',
        'destination_from',
        'destination_to',
        'flight_date',
        'transit_time',
        'luggage',
        'food',
        'b2b_fare',
        'b2c_fare',
        'group',
        'full_airport_name',
        'airlines',
        'status',
    ];

    public function upload()
    {
        return $this->belongsTo(AirTicketFile::class, 'air_ticket_file_id');
    }
}
