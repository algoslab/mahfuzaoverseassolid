<?php

namespace App\Models\Supper_Admin\Sponsor;

use App\Models\Admin\Process\Candidate;
use App\Models\Supper_Admin\Location\Currency;
use App\Models\Supper_Admin\Payroll\Expense\ExpenseCategory;
use App\Models\Supper_Admin\Payroll\Expense\ExpenseItem;
use Illuminate\Database\Eloquent\Model;

class SponsorTransaction extends Model
{
    protected $fillable =
        [
            'sponsor_id',
            'transaction_type',
            'payment_method',
            'currency',
            'amount',
            'bdt_amount',
            'candidate_id',
            'attachment',
            'transaction_note',
            'note'
        ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
