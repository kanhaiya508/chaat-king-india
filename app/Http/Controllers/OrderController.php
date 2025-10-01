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
        $order = Order::with(['customer', 'table', 'staff'])->findOrFail($orderId);
        return view('print.order-receipt', compact('order'));
    }

    public function kotPrint($orderId)
    {
        $order = Order::with(['items' => function($query) {
            $query->where('kot_printed', false)->orderBy('created_at', 'desc'); // सिर्फ unprinted items, newest first
        }, 'items.variant'])->findOrFail($orderId);
        
        // Check if there are any unprinted items
        if ($order->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No new items to print. All items have already been printed.'
            ], 400);
        }
        
        // Mark only the unprinted items as printed
        $order->items()->where('kot_printed', false)->update([
            'kot_printed' => true,
            'kot_printed_at' => now(),
        ]);
        
        return view('print.kot-receipt', compact('order'));
    }

    public function finalBill($orderId)
    {
        $order = Order::with(['customer', 'table', 'staff', 'payments'])->findOrFail($orderId);
        return view('print.final-bill', compact('order'));
    }

    public function share($orderId)
    {
        // Shareable web bill link
        $order = Order::with(['branch', 'customer', 'staff', 'items', 'payments'])->findOrFail($orderId);
        return view('print.order-share', compact('order'));
    }
}
