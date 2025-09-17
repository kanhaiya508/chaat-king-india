<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAddon extends Model
{


    protected $fillable = [
        'item_id',
        'name',
        'price',
    ];


    protected $table = "item_add_ons";
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getAddons()
    {
        return ItemAddon::whereIn('id', $this->addon_ids ?? [])->get();
    }
}
