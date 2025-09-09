<?php

namespace App\Models\Admin\HRM;

use App\Models\Admin\Enquiry\PhoneCallFollowup;
use App\Models\Admin\MyOffice\Branch;
use App\Models\Admin\MyOffice\Department;
use App\Models\Admin\MyOffice\Designation;
use App\Models\Admin\MyOffice\Roster;
use App\Models\Business\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Employee extends Model
{
    protected $fillable =
    [
        'company_id',
        'branch_id',
        'first_name',
        'last_name',
        'employee_code',
        'religion',
        'gender',
        'marital_status',
        'date_of_birth',
        'date_of_joining',
        'blood_group',
        'personal_phone',
        'personal_email',
        'contact_person_number',
        'photo',
        'office_phone',
        'office_email',
        'nid_number',
        'current_address',
        'permanent_address',
        'note',
        'role_id',
        'department_id',
        'designation_id',
        'roster_id',
        'basic_salary_monthly',
        'basic_salary_daily',
        'mobile_allowance',
        'salary_pay_method',
        'contract_type',
        'access_card',
        'add_finger',
        'is_active_finger',
        'is_hold_salary',
        'is_mobile_bill',
        'is_accommodation',
        'white_list',
        'weekend_day',
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
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
    public function roster()
    {
        return $this->belongsTo(Roster::class, 'roster_id');
    }
    public function phone_call_followups()
    {
        return $this->hasMany(PhoneCallFollowup::class);
    }
}
