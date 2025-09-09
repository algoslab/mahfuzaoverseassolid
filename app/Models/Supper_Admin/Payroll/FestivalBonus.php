<?php

namespace App\Models\Supper_Admin\Payroll;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\MyOffice\Department;
use Illuminate\Database\Eloquent\Model;

class FestivalBonus extends Model
{
    protected $fillable =
        [
            'month',
            'amount_type',
            'amount',
            'note'
        ];
}
