<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\MyOffice\Branch;
use App\Models\Business\Company;
use App\Models\User;

class CandidateType extends Model
{
    protected $fillable =
    [
        'company_id',
        'name', 
        'note',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}

