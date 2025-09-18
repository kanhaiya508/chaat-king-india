<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tablecategory;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $tablecategories = Tablecategory::with('tables')->get();
        return view('app.orders.index', compact('tablecategories'));
    }



    public function print($orderId)
    {
        $order = Order::with(['customer'])->findOrFail($orderId);
        return view('print.orders-receipt', compact('order'));
    }

    public function kotPrint($orderId)
    {
        $order = Order::with(['items.variant', 'items.addon'])->findOrFail($orderId);
        return view('print.kot-receipt', compact('order'));
    }

    public function share($orderId)
    {
        // Shareable web bill link
        $order = Order::with(['branch', 'customer', 'staff', 'items', 'payments'])->findOrFail($orderId);
        return view('print.order-share', compact('order'));
    }
}
