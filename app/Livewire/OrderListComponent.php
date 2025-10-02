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
    public $cancelReason = '';

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
        $this->cancelReason = '';
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->orderToDelete = null;
        $this->deletePassword = '';
        $this->deletePasswordError = '';
        $this->cancelReason = '';
    }

    public function deleteOrder()
    {
        // Get current user's password for validation
        $currentUser = auth()->user();
        
        if (!$currentUser) {
            $this->deletePasswordError = 'User not authenticated.';
            return;
        }
        
        // Check if entered password matches current user's password
        if (!password_verify($this->deletePassword, $currentUser->password)) {
            $this->deletePasswordError = 'Incorrect password. Please try again.';
            return;
        }

        if ($order = Order::find($this->orderToDelete)) {
            $orderId = $order->id;
            
            // Validate cancel reason
            if (empty(trim($this->cancelReason))) {
                $this->deletePasswordError = 'Please provide a reason for cancellation.';
                return;
            }
            
            // Cancel the order instead of deleting
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancelled_by' => $currentUser->id,
                'cancel_reason' => trim($this->cancelReason)
            ]);
            
            $this->showDeleteModal = false;
            $this->orderToDelete = null;
            $this->deletePassword = '';
            $this->deletePasswordError = '';
            $this->cancelReason = '';
            
            session()->flash('success', "Order #$orderId cancelled successfully.");
        } else {
            $this->deletePasswordError = "Order not found.";
        }
    }
}
