<?php

namespace App\Models\Supper_Admin\Sponsor;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\People\Delegate;
use App\Models\Admin\Process\JobList;
use App\Models\Supper_Admin\Location\Country;
use App\Models\Supper_Admin\Location\Currency;
use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{
    protected $fillable =
        [
            'sponsor_id',
            'job_list_id',
            'country_id',
            'issue_date',
            'age_from',
            'age_to',
            'visa_number',
            'visa_qty',
            'type',
            'gender',
            'currency',
            'monthly_salary',
            'salary_bdt_amount',
            'purchase_amount',
            'purchase_bdt_amount',
            'payment_type',
            'agent_price',
            'agent_bdt_price',
            'candidate_price',
            'candidate_bdt_price',
            'commission_amount',
            'commission_bdt_amount',
            'demand_letter',
            'attachment',
            'note',
            'provide_food',
            'provide_accommodation',
            'status'
        ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function jobList()
    {
        return $this->belongsTo(JobList::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
