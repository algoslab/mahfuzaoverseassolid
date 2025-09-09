<?php

namespace App\Models\Admin\Enquiry;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\Process\CandidateType;
use Illuminate\Database\Eloquent\Model;

class VisitorBook extends Model
{
    protected $fillable = [
        'phone',
        'full_name',
        'address',
        'is_candidate',
        'employee_id',
        'candidate_type_id',
        'reference_type',
        'note',
        'entry_time',
        'how_find_us_id',
    ];

    public function candidateType()
    {
        return $this->belongsTo(CandidateType::class, 'candidate_type_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function howFindUs()
    {
        return $this->belongsTo(HowFindUs::class, 'how_find_us_id');
    }
}
