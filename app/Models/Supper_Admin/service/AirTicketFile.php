<?php

namespace App\Models\Supper_Admin\service;

use App\Models\Supper_Admin\service\AirTicket;
use Illuminate\Database\Eloquent\Model;

class AirTicketFile extends Model
{
    protected $fillable = [
        'file_name',
        'upload_date',
    ];

    public function tickets()
    {
        return $this->hasMany(AirTicket::class, 'air_ticket_file_id');
    }
}
