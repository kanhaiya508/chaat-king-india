<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{

    use  HasBranch;

    protected $fillable = [
        'start_time',
        'end_time',
        'capacity',
        'is_active',
        'branch_id',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    // Slot multiple event halls me use ho sakta hai
    public function eventHalls()
    {
        return $this->belongsToMany(EventHall::class, 'event_hall_slots', 'slot_id', 'event_hall_id');
    }
}
