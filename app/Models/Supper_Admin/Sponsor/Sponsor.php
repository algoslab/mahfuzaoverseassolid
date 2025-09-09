<?php

namespace App\Models\Supper_Admin\Sponsor;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\People\Agent;
use App\Models\Admin\People\Delegate;
use App\Models\Admin\People\DelegateOffice;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable =
        [
            'user_id',
            'sponsor_type',
            'agent_id',
            'delegate_id',
            'delegate_office_id',
            'sponsor_name',
            'cell_number',
            'email',
            'opening_balance',
            'balance',
            'nid',
            'sponsor_photo',
            'address',
            'note'
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function delegate()
    {
        return $this->belongsTo(Delegate::class);
    }
    public function delegateOffice()
    {
        return $this->belongsTo(DelegateOffice::class);
    }

    public function sponsorTransactions()
    {
        return $this->hasMany(SponsorTransaction::class);
    }
}
