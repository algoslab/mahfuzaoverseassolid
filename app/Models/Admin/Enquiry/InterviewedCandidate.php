<?php

namespace App\Models\Admin\Enquiry;

use App\Models\Admin\HRM\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewedCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'full_name',
        'date_of_birth',
        'note',
        'employee_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

} 