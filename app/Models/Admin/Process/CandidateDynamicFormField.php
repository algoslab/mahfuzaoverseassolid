<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;

class CandidateDynamicFormField extends Model
{
    protected $fillable =
        [
            'candidate_dynamic_form_id',
            'field_name',
            'updated_field_name'
        ];

    public function candidateDynamicForm()
    {
        return $this->belongsTo(CandidateDynamicForm::class, 'candidate_dynamic_form_id', 'id');
    }
}
