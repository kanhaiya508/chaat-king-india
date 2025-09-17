<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tablecategory extends Model
{
    use HasFactory,HasBranch;


    protected $table = 'tablecategories';

    protected $fillable = ['branch_id', 'name'];



    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    // Relationship: Tablecategory has many Tables
    public function tables()
    {
        return $this->hasMany(Table::class, 'tablecategory_id');
    }
}
