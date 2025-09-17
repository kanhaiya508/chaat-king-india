<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use  HasBranch;

    protected $fillable = ['user_id', 'name', 'branch_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
