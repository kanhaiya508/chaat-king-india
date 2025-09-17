<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasBranch
{
    // Auto-fill on create
    protected static function bootHasBranch(): void
    {
        static::creating(function ($model) {
            if (empty($model->branch_id)) {
                $model->branch_id = session('branch_id'); // current selected branch
            }
        });

        // Global scope for branch isolation
        static::addGlobalScope('branch', function (Builder $builder) {
            $branchId = session('branch_id');
            if ($branchId) {
                $builder->where($builder->getModel()->getTable() . '.branch_id', $branchId);
            }
        });
    }

    // Local scope (optional – kabhi global scope disable karke use karna ho)
    public function scopeForBranch(Builder $q, $branchId = null): Builder
    {
        return $q->withoutGlobalScope('branch')
            ->where($this->getTable() . '.branch_id', $branchId ?? session('branch_id'));
    }
}
