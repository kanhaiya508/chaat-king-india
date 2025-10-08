{{-- resources/views/print/order-receipt.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <style>
        /* Landscape print layout */
        @media print {
            @page {
                size: A4 landscape;
                margin: 0.5in;
            }
            
            body {
                transform: rotate(0deg);
                width: 100%;
                max-width: none;
            }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            font-weight: bold;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background: white;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                font-size: 10px;
                font-weight: bold;
            }
            
            .print-content {
                width: 100%;
                max-width: 200px;
                margin: 0;
                padding: 0;
            }
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
            margin: 3px 0;
        }

        table {
            width: 100%;
            font-size: 10px;
            font-weight: bold;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 1px 0;
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
            margin-top: 2px;
        }

        .mb-4 {
            margin-bottom: 2px;
        }
        
        .print-content {
            margin: 0;
            padding: 0;
            width: 100%;
            max-width: 200px;
            background: white;
        }
    </style>
</head>

<body onload="window.print()">

<div class="print-content">

    @php
        $branch = $order->branch; // Branch relation
        $round = (float) ($order->round_off ?? 0);
        $write = (float) ($order->write_off ?? 0);
        $grandTotal = (float) $order->total; // already subtotal - discount (+ taxes if any)
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
                @if ($order->remark)
                    <strong>Remark:</strong> {{ $order->remark }}
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
        @if ($order->table)
            <tr>
                <td colspan="2">
                    <strong>Table:</strong> {{ $order->table->name }}
                </td>
            </tr>
        @endif
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

    <!-- Special Instructions -->
    @if ($order->remark)
        <div class="bold">Special Instructions:</div>
        <div style="font-size: 9px; margin-bottom: 8px;">{{ $order->remark }}</div>
        <div class="line"></div>
    @endif

    <div class="center">
        Thank you! Visit Again.
        <div class="mt-4 muted">
            {{ $branch->name ?? 'Your Store' }} • {{ $branch->contact_number ?? '' }}
        </div>
    </div>

</div>

</body>

</html>
