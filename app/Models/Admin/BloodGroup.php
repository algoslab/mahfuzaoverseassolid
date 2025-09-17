<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Process\CandidatePersonalInfo;

class BloodGroup extends Model
{
    protected $guarded = ["id"];

    public function candidatePersonalInfos()
    {
        return $this->hasMany(CandidatePersonalInfo::class, 'blood_group_id');
    }

}
