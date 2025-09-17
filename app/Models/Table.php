<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{

    use  HasBranch;


    protected $fillable = ['id', 'name', 'branch_id', 'tablecategory_id'];

    public function tablecategory()
    {
        return $this->belongsTo(Tablecategory::class);
    }



    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function latestOrder()
    {
        return $this->hasOne(Order::class)->latestOfMany();
    }
}
