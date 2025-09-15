<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;

class CandidateTransaction extends Model
{
    protected $guarded = ["id"];

    // Static array of predefined purposes
    public static array $transactionPurposes = [
        1 => 'Registration Fee',
        2 => 'Consultation',
        3 => 'Document Processing',
        4 => 'Visa Fee',
        5 => 'Travel Expense',
        6 => 'Others',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
