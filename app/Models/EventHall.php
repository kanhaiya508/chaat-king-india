<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use Illuminate\Database\Eloquent\Model;

class EventHall extends Model
{
    protected $fillable = ['branch_id', 'name'];

    use  HasBranch;

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Event hall ke multiple slots honge through pivot table
    public function slots()
    {
        return $this->belongsToMany(Slot::class, 'event_hall_slots', 'event_hall_id', 'slot_id');
    }
}
