<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'contact_number',
        'gst_number',
        'address',
        'is_active',
    ];

    // relation with users (many-to-many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_user');
    }

    // Example relation with orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
