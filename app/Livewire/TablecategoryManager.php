<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tablecategory;
use Livewire\WithPagination;

class TablecategoryManager extends Component
{
    use WithPagination;

    public $name;
    public $message;
    public $tablecategoryId;
    public $isEditing = false;

    public function render()
    {
        $tablecategories = Tablecategory::latest()->paginate(10);
        return view('app.livewire.tablecategory-manager', [
            'tablecategories' => $tablecategories,
        ])->layout('app.layouts.app');
    }

    public function saveTablecategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($this->isEditing) {
            $tablecategory = Tablecategory::findOrFail($this->tablecategoryId);
            $tablecategory->update(['name' => $this->name]);
            $message = 'Table Category updated successfully!';
        } else {
            Tablecategory::create(['name' => $this->name]);
            $message = 'Table Category added successfully!';
        }

        $this->resetForm();
        $this->dispatch('show-toast', $message);
    }

    public function editTablecategory($id)
    {
        $tablecategory = Tablecategory::findOrFail($id);
        $this->tablecategoryId = $tablecategory->id;
        $this->name = $tablecategory->name;
        $this->isEditing = true;
    }

    public function deleteTablecategory($id)
    {
        Tablecategory::destroy($id);
        $this->dispatch('show-toast', 'Table Category deleted.');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->tablecategoryId = null;
        $this->isEditing = false;
    }
}
