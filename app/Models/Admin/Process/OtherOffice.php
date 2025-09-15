<?php

namespace App\Models\Admin\Process;

use Illuminate\Database\Eloquent\Model;

class OtherOffice extends Model
{
    protected $fillable =
        [
            'name',
            'budget_carrier',
            'note',
            'status',
        ];
}
