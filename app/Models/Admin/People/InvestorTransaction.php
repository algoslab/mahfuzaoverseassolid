<?php

namespace App\Models\Admin\People;

use App\Models\Admin\Process\Candidate;
use Illuminate\Database\Eloquent\Model;

class InvestorTransaction extends Model
{
    protected $fillable = [
        'investor_id',
        'transaction_type',
        'payment_method',
        'currency',
        'amount',
        'bdt_amount',
        'candidate_id',
        'attachment',
        'transaction_note',
        'note',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class, 'investor_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
