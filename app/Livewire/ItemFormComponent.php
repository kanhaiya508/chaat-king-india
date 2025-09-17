<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Category;
use App\Models\ItemVariant;
use App\Models\ItemAddon;
use Livewire\WithPagination;

class ItemFormComponent extends Component
{
    use WithPagination;

    public $step = 1;
    public $itemId, $name, $category_id, $type, $is_available = true;
    public $variants = [];
    public $addons = [];
    public $viewItem;
    public $editing = false;
    public $editingItemName = null;
    public function mount($itemId = null)
    {
        if ($itemId) {
            $this->editItem($itemId);
        }
    }

    public function saveItem()
    {
        $this->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required',
        ]);

        $item = Item::updateOrCreate(
            ['id' => $this->itemId],
            [
                'user_id' => auth()->id(),
                'name' => $this->name,
                'category_id' => $this->category_id,
                'type' => $this->type,
                'is_available' => $this->is_available,
            ]
        );

        $this->itemId = $item->id;
        $this->step = 2;
    }

    public function saveVariants()
    {
        $this->validate([
            'variants.*.label' => 'required|string|max:100',
            'variants.*.price' => 'required|numeric|min:0',
        ]);

        ItemVariant::where('item_id', $this->itemId)->delete();

        foreach ($this->variants as $variant) {
            ItemVariant::create([
                'item_id' => $this->itemId,
                'label' => $variant['label'] ?? '',
                'price' => $variant['price'] ?? 0,
            ]);
        }

        $this->step = 3;
    }

    public function saveAddons()
    {
        foreach ($this->addons as $index => $addon) {
            $this->validate([
                "addons.$index.name" => 'required|string|max:50',
                "addons.$index.price" => 'required|numeric|min:0',
            ]);
        }

        ItemAddon::where('item_id', $this->itemId)->delete();

        foreach ($this->addons as $addon) {
            ItemAddon::create([
                'item_id' => $this->itemId,
                'name' => $addon['name'],
                'price' => $addon['price'],
            ]);
        }

        $this->reset(['itemId', 'name', 'category_id', 'type', 'is_available', 'variants', 'addons']);
        $this->step = 1;
        $this->editing = false;
        $this->dispatch('show-toast', 'Item saved successfully!');
    }


    public function addVariant()
    {
        $this->variants[] = ['label' => '', 'price' => ''];
    }

    public function addAddons()
    {
        $this->addons[] = ['name' => '', 'price' => ''];
    }
    public function editItem($id)
    {
        $this->step = 1;
        $this->editing = true;

        $item = Item::with(['variants', 'addons'])->findOrFail($id);

        $this->itemId = $item->id;
        $this->name = $item->name;
        $this->category_id = $item->category_id;
        $this->type = $item->type;
        $this->is_available = $item->is_available;
        $this->variants = $item->variants->toArray();
        $this->addons = $item->addons->toArray();

        $this->editingItemName = $item->name;
    }

    public function deleteItem($id)
    {
        ItemVariant::where('item_id', $id)->delete();
        ItemAddon::where('item_id', $id)->delete();
        Item::findOrFail($id)->delete();

        $this->dispatch('show-toast', 'Item deleted successfully!');
    }

    public function viewItemDetail($id)
    {
        $this->viewItem = Item::with(['category', 'variants', 'addons'])->findOrFail($id);
        $this->dispatch('open-item-detail');
    }

    public function render()
    {
        $items = Item::with('category')->latest()->paginate(10);
        return view('app.livewire.item-form', [
            'categories' => Category::all(),
            'types' => Item::allowedTypes(),
            'items' => $items,
        ])->layout('app.layouts.app');
    }

    public function removeAddon($index)
    {
        // agar yeh existing database item hai to usse bhi delete karo
        $addon = $this->addons[$index] ?? null;

        if (isset($addon['id'])) {
            ItemAddon::where('id', $addon['id'])->delete();
        }

        // local array se hata do
        unset($this->addons[$index]);
        $this->addons = array_values($this->addons); // reindex
    }

    public function removeVariant($index)
    {
        $variant = $this->variants[$index] ?? null;

        if (isset($variant['id'])) {
            ItemVariant::where('id', $variant['id'])->delete();
        }

        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }


    public function resetForm()
    {
        $this->reset([
            'name',
            'category_id',
            'type',
            'is_available',
            'variants',
            'addons',
            'step',
            'editing',
            'editingItemName',
            'itemId'
        ]);
        $this->step = 1;
    }
}
