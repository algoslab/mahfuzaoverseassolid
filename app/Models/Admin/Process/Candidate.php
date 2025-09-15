<?php

namespace App\Models\Admin\Process;

use App\Models\Admin\Profession;
use App\Models\Admin\People\Agent;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Process\CandidateType;
use App\Models\Supper_Admin\Location\Country;
use App\Models\Admin\Process\CandidateLocation;
use App\Models\Admin\Process\CandidatePassport;
use App\Models\Admin\Process\CandidateExperience;
use App\Models\Admin\Process\CandidatePersonalInfo;

class Candidate extends Model
{
    protected $guarded = ['id'];

    // Candidate Type relation
    public function candidateType()
    {
        return $this->belongsTo(CandidateType::class);
    }

    // Referral Agent relation
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'referral_agent_id');
    }

    // Interested Country relation
    public function country()
    {
        return $this->belongsTo(Country::class, 'interested_country_id');
    }

    // Interested Profession relation
    public function profession()
    {
        return $this->belongsTo(Profession::class, 'interested_profession_id');
    }

    public function personalInfo()
    {
        return $this->hasOne(CandidatePersonalInfo::class);
    }

    public function experiences()
    {
        return $this->hasOne(CandidateExperience::class);
    }


//    public function experiences()
//    {
//        return $this->hasMany(CandidateExperience::class);
//    }

    public function passport()
    {
        return $this->hasOne(CandidatePassport::class);
    }

    public function location()
    {
        return $this->hasOne(CandidateLocation::class);
    }

    public function files()
    {
        return $this->hasOne(CandidateFile::class);
    }
//    public function file()
//    {
//        return $this->hasOne(CandidateFile::class);
//    }
    public function transactions()
    {
        return $this->hasMany(CandidateTransaction::class);
    }

    public function agentTransactions()
    {
        return $this->hasMany(AgentTransaction::class);
    }

}
