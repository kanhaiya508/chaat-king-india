<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use Illuminate\Database\Eloquent\Model;

class EventHallSlot extends Model
{

    use  HasBranch;


    protected $table = 'event_hall_slots';

    protected $fillable = [
        'event_hall_id',
        'branch_id',
        'slot_id'
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
