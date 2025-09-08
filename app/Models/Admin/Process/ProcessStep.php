<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\MyOffice\Branch;
use App\Models\Business\Company;
use App\Models\User;

class ProcessStep extends Model
{
    protected $fillable =
    [
        'company_id',
        'name', 
        'country_id', 
        'gender',
        'process_category_id',
        'is_document',
        'is_scheduled',
        'is_youtube_link',
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
    public function country()
    {
        return $this->belongsTo(Branch::class, 'country_id');
    }
        public function processCategory()
    {
        return $this->belongsTo(ProcessCategory::class, 'process_category_id');
    }
}
