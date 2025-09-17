<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVariant extends Model
{
    protected $fillable = [
        'item_id',
        'label',
        'price',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
