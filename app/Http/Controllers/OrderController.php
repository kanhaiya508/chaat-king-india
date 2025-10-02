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
            $query->orderBy('kot_group_id', 'asc')
                  ->orderBy('kot_printed', 'asc')
                  ->orderBy('created_at', 'desc');
        }, 'items.variant', 'customer', 'table', 'staff'])->findOrFail($orderId);
        
        // Check if there are any items
        if ($order->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No items found in this order.'
            ], 400);
        }
        
        return view('print.kot-receipt', compact('order'));
    }

    public function kotGroupPrint($orderId, $kotGroupId)
    {
        $order = Order::with(['items' => function($query) use ($kotGroupId) {
            $query->where('kot_group_id', $kotGroupId)->orderBy('created_at', 'desc');
        }, 'items.variant', 'customer', 'table', 'staff'])->findOrFail($orderId);
        
        // Check if there are any items in this group
        if ($order->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No items found in this KOT group.'
            ], 400);
        }
        
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
