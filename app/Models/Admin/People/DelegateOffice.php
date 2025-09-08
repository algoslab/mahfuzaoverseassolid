<?php

namespace App\Models\Admin\People;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\MyOffice\Branch;
use App\Models\Business\Company;
use App\Models\User;
class DelegateOffice extends Model
{
    protected $fillable =
    [
        'company_id',
        'branch_id', 
        'delegate_id', 
        'office_name',
        'contact_number',
        'licence_number', 
        'attachment',
        'address',
        'user_id',
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
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function delegate()
    {
        return $this->belongsTo(Delegate::class, 'delegate_id');
    }
}
