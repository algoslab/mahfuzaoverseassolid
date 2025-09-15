<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;

class CandidateFile extends Model
{
    protected $guarded = ["id"];

    // Candidate
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
