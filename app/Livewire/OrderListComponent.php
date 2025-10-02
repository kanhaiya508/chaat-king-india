<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class OrderListComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';           // ⬅️ add
    public $selectedOrder = null;
    public $showDeleteModal = false;
    public $orderToDelete = null;
    public $deletePassword = '';
    public $deletePasswordError = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedType()
    {
        $this->resetPage();
    } // ⬅️ add

    public function openOrderInForm($orderId)
    {
        $this->dispatch('openOrderListForm')->to(OrderListComponent::class);
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with('items')->find($orderId);
    }

    public function render()
    {
        $orders = Order::with(['items', 'customer'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('id', $this->search)
                        ->orWhereHas('customer', function ($cq) {
                            $cq->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('phone', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->type !== '', function ($q) {   // ⬅️ filter by type
                $q->where('type', $this->type);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.livewire.order-list-component', compact('orders'))
            ->layout('app.layouts.app');
    }

    public function confirmDeleteOrder($orderId)
    {
        $this->orderToDelete = $orderId;
        $this->showDeleteModal = true;
        $this->deletePassword = '';
        $this->deletePasswordError = '';
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->orderToDelete = null;
        $this->deletePassword = '';
        $this->deletePasswordError = '';
    }

    public function deleteOrder()
    {
        // Hardcoded password for deletion
        $correctPassword = 'admin123';
        
        if ($this->deletePassword !== $correctPassword) {
            $this->deletePasswordError = 'Incorrect password. Please try again.';
            return;
        }

        if ($order = Order::find($this->orderToDelete)) {
            $orderId = $order->id;
            $order->items()->delete();
            $order->delete();
            
            $this->showDeleteModal = false;
            $this->orderToDelete = null;
            $this->deletePassword = '';
            $this->deletePasswordError = '';
            
            session()->flash('success', "Order #$orderId deleted successfully.");
        } else {
            $this->deletePasswordError = "Order not found.";
        }
    }
}
