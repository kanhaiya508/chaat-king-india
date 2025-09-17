<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable
{

    use  HasBranch;
    protected $fillable = [
        'name',
        'phone',
        'address',
        'branch_id',
        'email',
        'password',
        'vehicle_number'
    ];

    protected $hidden = [
        'password',
    ];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function fcmTokens()
    {
        return $this->hasMany(CustomerFcmToken::class);
    }
}
