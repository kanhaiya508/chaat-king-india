<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Table;
use App\Models\Tablecategory;

class TableManager extends Component
{
    use WithPagination;

    public $name;
    public $tablecategory_id;
    public $tableId;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'tablecategory_id' => 'required|exists:tablecategories,id',
    ];

    public function render()
    {
        return view('app.livewire.table-manager', [
            'tables' => Table::with('tablecategory')->latest()->paginate(10),
            'tablecategories' => Tablecategory::all(),
        ])->layout('app.layouts.app');
    }

    public function saveTable()
    {
        $this->validate();

        if ($this->isEditing) {
            Table::findOrFail($this->tableId)->update([
                'name' => $this->name,
                'tablecategory_id' => $this->tablecategory_id,
            ]);
            $msg = 'Table updated successfully!';
        } else {
            Table::create([
                'name' => $this->name,
                'tablecategory_id' => $this->tablecategory_id,
            ]);
            $msg = 'Table added successfully!';
        }

        $this->resetForm();
        $this->dispatch('show-toast', $msg);
    }

    public function editTable($id)
    {

        $table = Table::findOrFail($id);
        $this->tableId = $table->id;
        $this->name = $table->name;
        $this->tablecategory_id = $table->tablecategory_id;
        $this->isEditing = true;
    }

    public function deleteTable($id)
    {
        Table::destroy($id);
        $this->dispatch('show-toast', 'Table deleted.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'tableId', 'tablecategory_id', 'isEditing']);
        $this->resetValidation();
    }
}
