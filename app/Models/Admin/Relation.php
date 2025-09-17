<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Process\CandidatePersonalInfo;

class Relation extends Model
{
    protected $guarded = ["id"];

    public function candidatePersonalInfos()
    {
        return $this->hasMany(CandidatePersonalInfo::class, 'relation_with_nominee_id');
    }

}
