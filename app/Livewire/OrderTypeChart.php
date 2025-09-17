<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderTypeChart extends Component
{
    public function getChartData()
    {
        $raw = Order::selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type')
            ->mapWithKeys(fn ($count, $type) => [strtolower(str_replace('_','-',$type)) => (int)$count])
            ->toArray();

        $types = ['takeaway', 'delivery', 'dine-in'];
        $data = [];
        foreach ($types as $t) {
            $data[$t] = $raw[$t] ?? 0;
        }

        $total = array_sum($data);

        return [
            'labels'  => ['Takeaway', 'Delivery', 'Dine-in'],
            'counts'  => array_values($data),
            'mapping' => $data,
            'total'   => $total,
        ];
    }

    public function render()
    {
        return view('app.livewire.order-type-chart', [
            'chart' => $this->getChartData(),
        ]);
    }
}
