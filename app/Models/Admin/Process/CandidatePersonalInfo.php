<?php

namespace App\Models\Admin\Process;

use Carbon\Carbon;
use App\Models\Admin\Gender;
use App\Models\Admin\Relation;
use App\Models\Admin\Religion;
use App\Models\Admin\BloodGroup;
use Illuminate\Database\Eloquent\Model;

class CandidatePersonalInfo extends Model
{
    protected $guarded = ["id"];

    // Candidate Relation
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Gender
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    // Religion
    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    // Blood Group
    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class, 'blood_group_id');
    }

    // Nominee Relation
    public function nomineeRelation()
    {
        return $this->belongsTo(Relation::class, 'relation_with_nominee_id');
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->age;
        }
        
        return null;
    }
}
