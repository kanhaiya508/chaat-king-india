<?php

namespace App\Models;

use App\Models\Concerns\HasBranch;
use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
        use  HasBranch;


    protected $fillable = [
        'booking_date',
        'event_hall_id',
        'slot_id',
        'remark',
        'branch_id',
    ];

    public function eventHall()
    {
        return $this->belongsTo(EventHall::class);
    }



    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
