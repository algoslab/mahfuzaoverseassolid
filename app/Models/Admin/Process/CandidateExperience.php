<?php

namespace App\Models\Admin\Process;

use App\Models\Admin\Profession;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supper_Admin\Location\Country;

class CandidateExperience extends Model
{
    protected $guarded = ["id"];

    // Candidate Relation
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Work Type (Profession)
    public function workType()
    {
        return $this->belongsTo(Profession::class, 'work_type_id');
    }

    // Travelled Country
    public function travelledCountry()
    {
        return $this->belongsTo(Country::class, 'travelled_country_id');
    }
}
