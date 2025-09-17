<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class TopItemsReport extends Component
{
    /** Top how many items to show */
    public $limit = 10;

public function getReport()
{
    $rows = \App\Models\OrderItem::query()
        ->leftJoin('items', 'items.id', '=', 'order_items.item_id')
        ->select([
            'order_items.item_id',
            \DB::raw("MAX(COALESCE(order_items.item_name, items.name)) as name"),
            \DB::raw('SUM(order_items.quantity) as total_qty'),
            \DB::raw('SUM(order_items.total_price) as total_revenue'),
            \DB::raw('COUNT(DISTINCT order_items.order_id) as orders_count'),
        ])
        ->groupBy('order_items.item_id')      // ✅ sirf id par group by
        ->orderByDesc('total_qty')
        ->limit($this->limit)
        ->get();

    $labels   = $rows->pluck('name')->toArray();
    $qtys     = $rows->pluck('total_qty')->map(fn($v)=>(int)$v)->toArray();
    $revenue  = $rows->pluck('total_revenue')->map(fn($v)=>(float)$v)->toArray();
    $orders   = $rows->pluck('orders_count')->map(fn($v)=>(int)$v)->toArray();

    return [
        'rows'     => $rows,
        'labels'   => $labels,
        'qtys'     => $qtys,
        'revenue'  => $revenue,
        'orders'   => $orders,
        'totalQty' => array_sum($qtys),
    ];
}


    public function render()
    {
        return view('app.livewire.top-items-report', [
            'report' => $this->getReport(),
        ]);
    }
}
