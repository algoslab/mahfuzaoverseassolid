<?php

namespace App\Models\Admin\People;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\HRM\Employee;
use App\Models\Admin\MyOffice\Branch;
use App\Models\Business\Company;
use App\Models\Supper_Admin\Location\Country;
use App\Models\User;
class Delegate extends Model
{
    protected $fillable =
    [
        'company_id',
        'branch_id', 
        'first_name', 
        'last_name',
        'delegate_code',
        'phone_number', 
        'email',
        'opening_balance',
        'country_id',
        'state',
        'sponsor_type',
        'agent_id',
        'employee_id',
        'user_id',
        'delegate_photo',
        'opening_balance_sheet',
        'current_address',
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

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
