<?php

namespace App\Models\Admin\Enquiry;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\Process\CandidateType;
use App\Models\Supper_Admin\Location\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'full_name',
        'email',
        'country_id',
        'candidate_type_id',
        'employee_id',
        'entry_type',
        'is_candidate',
        'note',
        'followup_date',
        'followup_time',
        'how_find_us_id',
        'process',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function candidateType()
    {
        return $this->belongsTo(CandidateType::class);
    }

    public function howFindUs()
    {
        return $this->belongsTo(HowFindUs::class, 'how_find_us_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
