<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EventHall;
use App\Models\Slot;
use App\Models\EventBooking;

class EventBookingForm extends Component
{
    public $eventHalls = [];
    public $slots = [];
    public $booking_date;
    public $selectedHall;
    public $selectedSlot;
    public $remark;
    public $bookedSlots = [];
    public $bookings = [];


    public function loadAllBookings()
    {
        $this->bookings = EventBooking::with(['slot', 'eventHall'])
            ->orderBy('booking_date', 'desc')
            ->latest()
            ->get();
    }

    public function mount()
    {
        $this->eventHalls = EventHall::all();
        $this->slots = collect(); // Empty initially
        $this->loadAllBookings();
    }

    public function updated($property)
    {
        if (in_array($property, ['booking_date', 'selectedHall'])) {
            $this->refreshSlots();
        }
    }

    protected function refreshSlots()
    {
        if ($this->booking_date && $this->selectedHall) {
            $this->slots = Slot::where('is_active', 1)->get();

            $this->bookedSlots = EventBooking::where('booking_date', $this->booking_date)
                ->where('event_hall_id', $this->selectedHall)
                ->pluck('slot_id')
                ->toArray();
        } else {
            $this->slots = collect();
            $this->bookedSlots = [];
        }

        $this->loadAllBookings();
    }
    public function saveBooking()
    {
        $this->validate([
            'booking_date' => 'required|date',
            'selectedHall' => 'required|exists:event_halls,id',
            'selectedSlot' => 'required|exists:slots,id',
            'remark' => 'nullable|string|max:255'
        ]);

        if (EventBooking::where('booking_date', $this->booking_date)
            ->where('event_hall_id', $this->selectedHall)
            ->where('slot_id', $this->selectedSlot)
            ->exists()
        ) {
            $this->addError('selectedSlot', 'This slot is already booked.');
            return;
        }

        EventBooking::create([
            'booking_date' => $this->booking_date,
            'event_hall_id' => $this->selectedHall,
            'slot_id' => $this->selectedSlot,
            'remark' => $this->remark,
        ]);

        session()->flash('success', 'Booking saved successfully!');
        $this->reset(['selectedSlot', 'remark']);
        $this->refreshSlots();
    }

    public function render()
    {
        return view('app.livewire.event-booking-form')->layout('app.layouts.app');
    }

    public function deleteBooking($id)
    {
        $booking = EventBooking::find($id);

        if ($booking) {
            $booking->delete();
            session()->flash('success', 'Booking deleted successfully!');
        } else {
            session()->flash('error', 'Booking not found.');
        }

        $this->loadAllBookings(); // Refresh list
    }
}
