<?php

namespace App\Models\Supper_Admin\Attendance_Leave;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\MyOffice\Department;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable =
        [
            'department_id',
            'employee_id',
            'date',
            'date_details',
            'check_in',
            'check_out',
            'is_holiday',
            'is_weekend',
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
}
