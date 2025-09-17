<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasBranch;


class OtherExpense extends Model
{

    use HasBranch;
    protected $fillable = [
        'title',
        'amount',
        'branch_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
