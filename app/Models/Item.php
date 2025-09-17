<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    use  HasBranch;


    protected $fillable = [
        'user_id',
        'name',
        'category_id',
        'is_available',
        'branch_id',
    ];




    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }




    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variants()
    {
        return $this->hasMany(ItemVariant::class);
    }

    public function addons()
    {
        return $this->hasMany(ItemAddon::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}
