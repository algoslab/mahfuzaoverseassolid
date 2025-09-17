<?php


namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateTypeField extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_type_id',
        'step_name',
        'field_name',
        'attr_value',
        'is_enable'
    ];

    public function candidateType()
    {
        return $this->belongsTo(CandidateType::class);
    }

}
