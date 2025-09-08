<?php

namespace App\Models\Admin\People;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\MyOffice\Branch;
use App\Models\Business\Company;
use App\Models\Supper_Admin\Location\Country;
use App\Models\Supper_Admin\Location\District;
use App\Models\Supper_Admin\Location\Division;
use App\Models\Supper_Admin\Location\Thana;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable =
    [
        'company_id',
        'branch_id', 
        'first_name', 
        'last_name',
        'agent_code',
        'phone_number', 
        'email',
        'opening_balance',
        'date_of_birth',
        'take_registration_fee',
        'registration_fee_amount',
        'country_id',
        'division_id',
        'district_id',
        'thana_id',
        'employee_id',
        'user_id',
        'agent_photo',
        'passport_scan_copy',
        'attachment',
        'opening_balance_sheet',
        'current_address',
        'parmanent_address',
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
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function thana()
    {
        return $this->belongsTo(Thana::class, 'thana_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
