<?php

namespace App\Models\Supper_Admin\Sponsor;

use App\Models\Admin\Process\JobList;
use App\Models\Supper_Admin\Location\Country;
use App\Models\Supper_Admin\Location\Currency;
use Illuminate\Database\Eloquent\Model;

class MarketingVisa extends Model
{
    protected $fillable =
        [
            'job_list_id',
            'country_id',
            'type',
            'gender',
            'salary_currency_id',
            'monthly_salary',
            'cost_currency_id',
            'cost',
            'available_qty',
            'registration_fee',
            'send_sms_to_agent',
            'attachment',
            'note',
            'status'
        ];

    public function jobList()
    {
        return $this->belongsTo(JobList::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function salaryCurrency()
    {
        return $this->belongsTo(Currency::class, 'salary_currency_id', 'id');
    }
    public function costCurrency()
    {
        return $this->belongsTo(Currency::class, 'cost_currency_id', 'id');
    }
}
