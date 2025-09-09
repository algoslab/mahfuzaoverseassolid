<?php

namespace App\Models\Admin\Enquiry;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowFindUs extends Model
{
    use HasFactory;
    protected $table = 'how_find_us';
    protected $fillable = ['name'];
} 