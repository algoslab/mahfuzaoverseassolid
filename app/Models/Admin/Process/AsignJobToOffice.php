<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;

use App\Models\Business\Company;
use App\Models\User;
class AsignJobToOffice extends Model
{
    protected $fillable =
    [
        'company_id',
        'user_id', 
        'processing_cost', 
        'proces_office_id',
        'process_category_id',
        'job_category_id',
        'job_list_id',
        'note',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function processOffice()
    {
        return $this->belongsTo(ProcessOffice::class, 'proces_office_id');
    }
    public function processCategory()
    {
        return $this->belongsTo(ProcessCategory::class, 'process_category_id');
    }
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
    public function jobList()
    {
        return $this->belongsTo(JobList::class, 'job_list_id');
    }
}
