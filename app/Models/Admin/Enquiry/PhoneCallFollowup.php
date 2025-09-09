<?php

namespace App\Models\Admin\Enquiry;

use App\Models\Admin\Enquiry\PhoneCall;
use App\Models\Admin\HRM\Employee;
use Illuminate\Database\Eloquent\Model;

class PhoneCallFollowup extends Model
{
    protected $fillable = [
        'phone_call_id',
        'employee_id',
        'process',
        'note',
        'followup_date',
        'followup_time',
    ];

    public function phoneCall()
    {
        return $this->belongsTo(PhoneCall::class, 'phone_call_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
