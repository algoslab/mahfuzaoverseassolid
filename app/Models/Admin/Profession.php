<?php

namespace App\Models\Admin;

use App\Models\Admin\Process\Candidate;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Process\CandidateExperience;

class Profession extends Model
{
    protected $guarded = ["id"];

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'interested_profession_id');
    }

    public function candidateExperiences()
    {
        return $this->hasMany(CandidateExperience::class, 'work_type_id');
    }

}
