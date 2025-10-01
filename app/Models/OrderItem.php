<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    use  HasBranch;

    protected $fillable = [
        'order_id',
        'item_id',
        'variant_id',
        'item_name',
        'quantity',
        'price',
        'total_price',
        'addon_ids',
        'remark',
        'branch_id',
        'kot_group_id',
        'kot_printed',
        'kot_printed_at',
    ];



    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    protected $casts = [
        'addon_ids' => 'array',
        'kot_printed' => 'boolean',
        'kot_printed_at' => 'datetime',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    // App\Models\OrderItem.php
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function variant()
    {
        return $this->belongsTo(ItemVariant::class, 'variant_id');
    }

    public function getAddonDetails()
    {
        $addonIds = json_decode($this->addon_ids ?? '[]');
        return \App\Models\ItemAddon::whereIn('id', $addonIds)->get();
    }
}
