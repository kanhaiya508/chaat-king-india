<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use  HasBranch;
  
    protected $fillable = [
        'subtotal',
        'discount',
        'total',
        'remark',
        'customer_id',
        'table_id',
        'status',
        'branch_id',
        'delivery_partner_name',
        'delivery_partner_phone',
        'delivery_location',
        'delivery_distance',
        'type',
        'staff_id',
        'write_off',
        'write_off_reason',
        'round_off',
        'is_paid',
    ];



    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }


    public function staff()
    {
        return $this->belongsTo(Staff::class); // ya User::class if staff = users
    }
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
