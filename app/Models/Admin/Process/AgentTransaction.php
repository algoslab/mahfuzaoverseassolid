<?php

namespace App\Models\Admin\Process;

use App\Models\Admin\People\Agent;
use Illuminate\Database\Eloquent\Model;

class AgentTransaction extends Model
{
    protected $guarded = ["id"];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function careCandidate()
    {
        return $this->belongsTo(Candidate::class, 'care_candidate_id', 'id');
    }
}
