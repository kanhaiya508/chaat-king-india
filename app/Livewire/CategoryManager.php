<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; // v3 compatible attribute (optional)
use Livewire\WithPagination;

class CategoryManager extends Component
{
    use WithPagination;
    public $name;
    public $message;
    public $categoryId;
    public $isEditing = false;

    public function render()
    {
        $categories = Category::latest()->paginate(10); // paginate instead of get()
        return view('app.livewire.category-manager', [
            'categories' => $categories,
        ])->layout('app.layouts.app');
    }

    public function saveCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($this->isEditing) {
            $category = Category::findOrFail($this->categoryId);
            $category->update(['name' => $this->name]);
            $message = 'Category updated successfully!';
        } else {
            Category::create([
                'name' => $this->name,
                'user_id' => Auth::id(),
            ]);
            $message = 'Category added successfully!';
        }

        $this->resetForm();
        $this->dispatch('show-toast', $message);
    }



    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->isEditing = true;
    }

    public function deleteCategory($id)
    {
        Category::destroy($id);
        $this->dispatch('show-toast',  'Category deleted.');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->categoryId = null;
        $this->isEditing = false;
    }
}
