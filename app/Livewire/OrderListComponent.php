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

    public function deleteOrder($orderId)
    {
        if ($order = Order::find($orderId)) {
            $order->items()->delete();
            $order->delete();
            session()->flash('success', "Order #$orderId deleted successfully.");
        } else {
            session()->flash('error', "Order not found.");
        }
    }
}
