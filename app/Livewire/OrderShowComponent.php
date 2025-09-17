<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderShowComponent extends Component
{

    public $orderId;
    public $order;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->order = Order::with([
            'customer',
            'orderItems.item.addons',
            'orderItems.variant'
        ])->findOrFail($orderId);
    }

    public function render()
    {
        return view('app.livewire.order-show-component')->layout('app.layouts.app');
    }
}
