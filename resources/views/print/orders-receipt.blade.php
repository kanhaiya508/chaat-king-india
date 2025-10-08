{{-- resources/views/prints/order-receipt.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        /* Landscape print layout */
        @media print {
            @page {
                size: A4 landscape;
                margin: 0.5in;
            }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .muted {
            color: #333;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        table {
            width: 100%;
            font-size: 14px;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 2px 0;
        }

        .right {
            text-align: right;
        }

        .w-70 {
            width: 70%;
        }

        .w-30 {
            width: 30%;
        }

        .mt-4 {
            margin-top: 4px;
        }

        .mb-4 {
            margin-bottom: 4px;
        }

        @media print {
            body {
                background: white !important;
            }
            
            @page {
                margin: 0 !important;
                size: auto;
            }
            
            /* Disable print backgrounds */
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }
    </style>
</head>

<body onload="window.print()">

    @php
        $branch = $order->branch; // Branch relation
        $paid = $order->payments->sum('amount');
        $byMode = $order->payments->groupBy('mode'); // ['cash','upi','card'...]
        $round = (float) ($order->round_off ?? 0);
        $write = (float) ($order->write_off ?? 0);
        $grandTotal = (float) $order->total; // already subtotal - discount (+ taxes if any)
        $due = max(0, $grandTotal - $paid - $write);
    @endphp

    <!-- Header / Branch -->
    <div class="center bold">
        {{ $branch->name ?? 'Your Store' }}<br>
        <span class="muted">
            {{ $branch->address ?? '' }}<br>
            {{ $branch->contact_number ? 'Phone: ' . $branch->contact_number : '' }}<br>
            {{ $branch->gst_number ? 'GSTIN: ' . $branch->gst_number : '' }}
        </span>
        <div class="line"></div>
    </div>

    <!-- Order Meta -->
    <table>
        <tr>
            <td class="w-70"><strong>Order ID:</strong> #{{ $order->id }}</td>
            <td class="right w-30"><strong>{{ $order->type ? strtoupper($order->type) : '' }}</strong></td>
        </tr>
        <tr>
            <td><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</td>
            <td class="right">
                @if ($order->staff)
                    <strong>Staff:</strong> {{ $order->staff->name }}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Customer:</strong> {{ $order->customer->name ?? 'Walk-in' }}
                @if ($order->customer?->phone)
                    | <strong>Ph:</strong> {{ $order->customer->phone }}
                @endif
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- Items -->
    <table>
        @foreach ($order->items as $item)
            <tr>
                <td class="w-70">
                    <strong>{{ $item->item_name }}</strong><br>
                    Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}
                </td>
                <td class="right w-30">₹{{ number_format($item->total_price, 2) }}</td>
            </tr>

            @php $addons = $item->getAddonDetails(); @endphp
            @foreach ($addons as $addon)
                <tr>
                    <td class="w-70" style="padding-left:10px;">- {{ $addon->name }}</td>
                    <td class="right w-30">₹{{ number_format($addon->price, 2) }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>

    <div class="line"></div>

    <!-- Totals -->
    <table>
        <tr>
            <td class="bold">Subtotal</td>
            <td class="right">₹{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td class="bold">Discount</td>
            <td class="right">- ₹{{ number_format($order->discount, 2) }}</td>
        </tr>

        {{-- Optional rows (show only when non-zero) --}}
        @if (abs($round) > 0.0001)
            <tr>
                <td class="bold">Round Off</td>
                <td class="right">{{ $round >= 0 ? '+' : '-' }} ₹{{ number_format(abs($round), 2) }}</td>
            </tr>
        @endif

        <tr>
            <td class="bold">Total</td>
            <td class="right">₹{{ number_format($grandTotal, 2) }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- Payments -->
    <table>
        <tr>
            <td class="bold">Payments</td>
            <td></td>
        </tr>
        @forelse($byMode as $mode => $rows)
            @php $amt = $rows->sum('amount'); @endphp
            <tr>
                <td class="w-70">{{ strtoupper($mode) }}</td>
                <td class="right w-30">₹{{ number_format($amt, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="muted">No payments recorded</td>
            </tr>
        @endforelse

        @if ($write > 0)
            <tr>
                <td class="bold">Write-off</td>
                <td class="right">₹{{ number_format($write, 2) }}</td>
            </tr>
            @if ($order->write_off_reason)
                <tr>
                    <td colspan="2" class="muted">Reason: {{ $order->write_off_reason }}</td>
                </tr>
            @endif
        @endif

        <tr>
            <td class="bold">Amount Paid</td>
            <td class="right">₹{{ number_format($paid, 2) }}</td>
        </tr>
        <tr>
            <td class="bold">Balance</td>
            <td class="right">₹{{ number_format($due, 2) }}</td>
        </tr>
        @if ($due <= 0 && $paid > 0)
            <tr>
                <td colspan="2" class="center bold">PAID IN FULL</td>
            </tr>
        @elseif($due <= 0 && $paid == 0 && $order->is_paid)
            <tr>
                <td colspan="2" class="center bold">MARKED PAID (NO AMOUNT)</td>
            </tr>
        @endif
    </table>

    <div class="line"></div>

    <div class="center">
        Thank you! Visit Again.
        <div class="mt-4 muted">
            {{ $branch->name ?? 'Your Store' }} • {{ $branch->contact_number ?? '' }}
        </div>
    </div>

</body>

</html>
