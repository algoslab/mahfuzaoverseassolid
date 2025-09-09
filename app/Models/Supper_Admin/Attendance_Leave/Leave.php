<?php

namespace App\Models\Supper_Admin\Attendance_Leave;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\MyOffice\Department;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable =
        [
            'department_id',
            'employee_id',
            'leave_type',
            'no_of_days',
            'shift',
            'attachment',
            'note'
        ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveDates()
    {
        return $this->hasMany(LeaveDate::class);
    }
}
