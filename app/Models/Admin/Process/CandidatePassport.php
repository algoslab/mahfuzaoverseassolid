<?php

namespace App\Models\Admin\Process;

use Carbon\Carbon;
use App\Models\Admin\Process\Candidate;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supper_Admin\Location\District;

class CandidatePassport extends Model
{
    protected $guarded = ["id"];

    // Candidate relation
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Passport Issue District
    public function issuePlace()
    {
        return $this->belongsTo(District::class, 'passport_issue_place_id');
    }

    public function getPassportValidityAttribute()
    {
        if ($this->passport_issue_date && $this->passport_expired_date) {
            $issue = Carbon::parse($this->passport_issue_date);
            $expiry = Carbon::parse($this->passport_expired_date);
            $diff = $issue->diff($expiry);
            $result = $diff->format('%yy %mm %dd');

            return $result;
        }
        
        return null;
    }
}
