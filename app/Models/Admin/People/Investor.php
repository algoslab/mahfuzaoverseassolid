<?php

namespace App\Models\Admin\People;

use App\Models\Admin\HRM\Employee;
use App\Models\Supper_Admin\Location\Country;
use App\Models\Supper_Admin\Location\District;
use App\Models\Supper_Admin\Location\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cell_no',
        'email',
        'password',
        'investor_photo',
        'nid_scan_copy',
        'agreement_scan_copy',
        'attachment',
        'country_id',
        'division_id',
        'district_id',
        'employee_id',
        'current_address',
        'permanent_address',
        'note',
        'status',
        'recieved_no',
        'balance',
    ];

    protected $casts = [
        'attachment' => 'array',
        'status' => 'boolean',
    ];

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function divisions()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
    public function districts()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
} 