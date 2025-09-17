<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Slot;
use Livewire\WithPagination;

class SlotManager extends Component
{
    use WithPagination;

    public $start_time, $end_time, $capacity = 1, $is_active = true;
    public $slotId;
    public $isEditing = false;

    public function render()
    {
        $slots = Slot::latest()->paginate(10);
        return view('app.livewire.slot-manager', [
            'slots' => $slots,
        ])->layout('app.layouts.app');
    }

    public function saveSlot()
    {
        $this->validate([
            'capacity'   => 'required|integer|min:1',
        ]);

        if ($this->isEditing) {
            $slot = Slot::findOrFail($this->slotId);
            $slot->update($this->only(['start_time', 'end_time', 'capacity', 'is_active']));
            $message = 'Slot updated successfully!';
        } else {
            Slot::create($this->only(['start_time', 'end_time', 'capacity', 'is_active']));
            $message = 'Slot created successfully!';
        }

        $this->resetForm();
        $this->dispatch('show-toast', $message);
    }

    public function editSlot($id)
    {
        $slot = Slot::findOrFail($id);
        $this->slotId     = $slot->id;
        $this->start_time = $slot->start_time;
        $this->end_time   = $slot->end_time;
        $this->capacity   = $slot->capacity;
        $this->is_active  = $slot->is_active;
        $this->isEditing  = true;
    }

    public function deleteSlot($id)
    {
        Slot::destroy($id);
        $this->dispatch('show-toast', 'Slot deleted.');
    }

    public function resetForm()
    {
        $this->start_time = '';
        $this->end_time = '';
        $this->capacity = 1;
        $this->is_active = true;
        $this->slotId = null;
        $this->isEditing = false;
    }
}
