<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;
use App\Models\Supper_Admin\Location\State;
use App\Models\Supper_Admin\Location\Thana;
use App\Models\Supper_Admin\Location\Country;
use App\Models\Supper_Admin\Location\District;
use App\Models\Supper_Admin\Location\Division;
use App\Models\Supper_Admin\Location\PostOffice;

class CandidateLocation extends Model
{
    protected $guarded = ["id"];

    // Candidate
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // District
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // Thana
    public function thana()
    {
        return $this->belongsTo(Thana::class);
    }

    // Post Office
    public function postOffice()
    {
        return $this->belongsTo(PostOffice::class);
    }

    // State
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
