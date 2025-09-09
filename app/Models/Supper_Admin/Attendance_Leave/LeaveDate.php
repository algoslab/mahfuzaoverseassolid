<?php

namespace App\Models\Supper_Admin\Attendance_Leave;

use Illuminate\Database\Eloquent\Model;

class LeaveDate extends Model
{
    protected $fillable =
        [
            'leave_id',
            'leave_date'
        ];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }
}
