<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;

class CandidateDynamicForm extends Model
{
    protected $fillable =
        [
            'form_name',
            'background_image',
            'note',
            'status'
        ];

    public function candidateDynamicFormFields()
    {
        return $this->hasMany(CandidateDynamicFormField::class);
    }

    public function updatedCandidateDynamicFormFields()
    {
        return $this->hasMany(UpdatedCandidateDynamicFormField::class);
    }
}
