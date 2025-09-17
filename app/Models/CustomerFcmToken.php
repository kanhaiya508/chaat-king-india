<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerFcmToken extends Model
{
    protected $fillable = ['customer_id', 'token', 'device', 'last_used_at'];

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class);
    }
}
