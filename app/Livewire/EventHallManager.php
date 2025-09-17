<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EventHall;
use App\Models\Slot;
use Livewire\WithPagination;

class EventHallManager extends Component
{
    use WithPagination;

    public $name;
    public $selectedSlots = []; // Slot IDs for this event hall
    public $eventHallId;
    public $isEditing = false;

    public function render()
    {
        $eventHalls = EventHall::with('slots')->latest()->paginate(10);
        $allSlots = Slot::where('is_active', true)->get();

        return view('app.livewire.event-hall-manager', [
            'eventHalls' => $eventHalls,
            'allSlots' => $allSlots,
        ])->layout('app.layouts.app');
    }

    public function saveEventHall()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($this->isEditing) {
            $eventHall = EventHall::findOrFail($this->eventHallId);
            $eventHall->update(['name' => $this->name]);
            $eventHall->slots()->sync($this->selectedSlots);
            $message = 'Event hall updated successfully!';
        } else {
            $eventHall = EventHall::create(['name' => $this->name]);
            $eventHall->slots()->attach($this->selectedSlots);
            $message = 'Event hall created successfully!';
        }

        $this->resetForm();
        $this->dispatch('show-toast', $message);
    }

    public function editEventHall($id)
    {
        $eventHall = EventHall::findOrFail($id);
        $this->eventHallId = $eventHall->id;
        $this->name = $eventHall->name;
        $this->selectedSlots = $eventHall->slots->pluck('id')->toArray();
        $this->isEditing = true;
    }

    public function deleteEventHall($id)
    {
        EventHall::destroy($id);
        $this->dispatch('show-toast', 'Event hall deleted.');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->selectedSlots = [];
        $this->eventHallId = null;
        $this->isEditing = false;
    }
}
