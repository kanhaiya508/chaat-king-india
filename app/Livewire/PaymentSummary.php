<?php

namespace App\Livewire;

use App\Models\OrderPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Order;
use App\Models\OtherExpense; // ✅ add

class PaymentSummary extends Component
{
    /**
     * Options: today | week | month | year | custom
     */
    public string $range = 'today';

    public array $modes = ['cash', 'upi', 'card'];

    public ?string $fromDate = null;
    public ?string $toDate = null;

    public function setRange(string $range): void
    {
        $this->range = $range;
        if ($range !== 'custom') {
            $this->fromDate = null;
            $this->toDate = null;
        }
    }

    protected function dateWindow(): array
    {
        $now = Carbon::now();

        if ($this->range === 'custom' && $this->fromDate && $this->toDate) {
            return [
                Carbon::parse($this->fromDate)->startOfDay(),
                Carbon::parse($this->toDate)->endOfDay(),
            ];
        }

        return match ($this->range) {
            'today' => [$now->clone()->startOfDay(), $now->clone()->endOfDay()],
            'week'  => [$now->clone()->startOfWeek(), $now->clone()->endOfWeek()],
            'month' => [$now->clone()->startOfMonth(), $now->clone()->endOfMonth()],
            'year'  => [$now->clone()->startOfYear(), $now->clone()->endOfYear()],
            default => [$now->clone()->startOfDay(), $now->clone()->endOfDay()],
        };
    }

    public function render()
    {
        [$from, $to] = $this->dateWindow();

        // Per-mode payments
        $perMode = OrderPayment::query()
            ->whereBetween('created_at', [$from, $to])
            ->select(
                DB::raw('LOWER(mode) as mode'),
                DB::raw('COUNT(*) as tx_count'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->groupBy(DB::raw('LOWER(mode)'))
            ->get()
            ->keyBy('mode');

        // Normalize modes
        $cards = [];
        foreach ($this->modes as $mode) {
            $row = $perMode->get($mode);
            $cards[$mode] = [
                'mode'  => ucfirst($mode),
                'count' => (int)($row->tx_count ?? 0),
                'total' => (float)($row->total_amount ?? 0),
            ];
        }

        $grandTotal = array_sum(array_column($cards, 'total'));
        $grandCount = array_sum(array_column($cards, 'count'));

        // 🔹 Write-off aggregate (orders table se)
        $write = Order::query()
            ->whereBetween('created_at', [$from, $to])
            ->where('write_off', '>', 0)
            ->selectRaw('COUNT(*) as wo_orders, SUM(write_off) as wo_total')
            ->first();

        $writeOffTotal  = (float)($write->wo_total ?? 0);
        $writeOffOrders = (int)($write->wo_orders ?? 0);


        // 🔹 Write-off aggregate
        $write = Order::query()
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('SUM(COALESCE(write_off,0))  as wo_total')
            ->selectRaw('SUM(write_off > 0)          as wo_orders')
            ->first();

        $writeOffTotal  = (float) ($write->wo_total ?? 0);
        $writeOffOrders = (int)   ($write->wo_orders ?? 0);

        // 🔹 Discount aggregate  ✅ FIXED
        $disc = Order::query()
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('SUM(COALESCE(discount,0))   as disc_total')
            ->selectRaw('SUM(discount > 0)           as disc_orders')
            ->first();

        $discountTotal  = (float) ($disc->disc_total ?? 0);
        $discountOrders = (int)   ($disc->disc_orders ?? 0);



        // ✅ Expenses aggregate (NEW)
        $exp = OtherExpense::query()
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('COUNT(*) as exp_count, SUM(COALESCE(amount,0)) as exp_total')
            ->first();

        $expenseTotal = (float)($exp->exp_total ?? 0);
        $expenseCount = (int)  ($exp->exp_count ?? 0);

        // ✅ Marked Paid (No Amount) — is_paid=1 और कोई payment entry नहीं
        $paidNoAmt = Order::query()
            ->whereBetween('created_at', [$from, $to])
            ->where('is_paid', true)
            ->whereDoesntHave('payments') // no payment rows
            ->selectRaw('COUNT(*) as cnt, SUM(COALESCE(total,0)) as amt')
            ->first();

        $paidNoAmountCount  = (int)   ($paidNoAmt->cnt  ?? 0);
        $paidNoAmountTotal  = (float) ($paidNoAmt->amt  ?? 0.0);


        // (optional) Gross billed = collected + write-off + discount
        $grossBilled   = $grandTotal + $writeOffTotal + $discountTotal + $expenseTotal + $paidNoAmountTotal;

        // ✅ Net after expenses (NEW) — collection minus expenses
        $netAfterExpenses = $grandTotal - $expenseTotal;

        return view('app.livewire.payment-summary', [
            'cards'             => $cards,
            'grandTotal'        => $grandTotal,
            'grandCount'        => $grandCount,
            'from'              => $from,
            'to'                => $to,
            'discountTotal'     => $discountTotal,
            'discountOrders'    => $discountOrders,
            'writeOffTotal'     => $writeOffTotal,
            'writeOffOrders'    => $writeOffOrders,
            'grossBilled'       => $grossBilled,

            // NEW:
            'expenseTotal'      => $expenseTotal,
            'expenseCount'      => $expenseCount,
            'netAfterExpenses'  => $netAfterExpenses,

            'paidNoAmountCount' => $paidNoAmountCount,
            'paidNoAmountTotal' => $paidNoAmountTotal,
        ]);
    }
}
