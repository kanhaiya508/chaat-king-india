<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{

    use  HasBranch;

    protected $fillable = [
        'order_id',
        'mode',
        'amount',
        'transaction_id',
        'note',
        'branch_id',
    ];



    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
