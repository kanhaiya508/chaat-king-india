<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{

    protected $table = 'staff';

    protected $fillable = [
        'name',
        'father_name',
        'phone',
        'address',
        'aadhaar_number',
        'designation',
    ];
}
