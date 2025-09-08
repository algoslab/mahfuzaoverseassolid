<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'company_name',
        'company_code',
        'start_date',
        'email',
        'contact_number',
        'alternate_number',
        'country',
        'district',
        'city',
        'zip_code',
        'owner_name',
        'owner_number',
        'owner_email',
        'nid_no',
        'nid_photo',
        'comments',
        'checkbox',
        'status',
    ];

}
