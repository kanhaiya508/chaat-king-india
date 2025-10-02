{{-- resources/views/print/kot-receipt.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>KOT - Kitchen Order Ticket</title>
    <style>
        /* 80mm thermal approx */
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 280px;
            margin: 0 auto;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f5f5f5;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                min-height: auto;
                display: block;
            }

            .no-print {
                display: none !important;
            }

            .print-content {
                width: 100%;
                max-width: 280px;
                margin: 0 auto;
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
            margin: 6px 0;
        }

        table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 3px 0;
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

        .kot-header {
            background-color: #f0f0f0;
            padding: 8px;
            margin-bottom: 8px;
        }

        .print-content {
            margin: 0;
            padding: 10px;
            width: 100%;
            max-width: 280px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        @media print {
            .print-content {
                box-shadow: none;
                border-radius: 0;
                background: white;
            }
        }
    </style>
</head>

<body onload="window.print()" style="margin: 0; padding: 0;">

    <div class="print-content">

        @php
            $branch = $order->branch; // Branch relation
        @endphp

        {{-- <!-- KOT Header -->
    <div class="kot-header center bold">
        <div style="font-size: 16px;">KITCHEN ORDER TICKET</div>
        <div style="font-size: 12px;">{{ $branch->name ?? 'Your Store' }}</div>
    </div> --}}

        <!-- Order Info -->
        <table>
            <tr>
                <td class="w-70"><strong>Order ID:</strong> #{{ $order->id }}</td>
            </tr>
            <tr>
                <td><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</td>
            </tr>
        </table>
        <div class="line"></div>
        <!-- Items Only -->
        <div class="bold center" style="margin-bottom: 8px;">KITCHEN ORDER TICKET</div>
        @if ($order->items->count() > 0)
            <div class="muted small center" style="margin-bottom: 8px;">
                Items: {{ $order->items->count() }} | Total: ₹{{ number_format($order->items->sum('total_price'), 2) }}
            </div>
        @endif
        <table>
            @php $itemCount = 0; @endphp
            @foreach ($order->items as $item)
                @php $itemCount++; @endphp
                <tr>
                    <td class="w-70">
                        <strong>{{ $item->item_name }}</strong><br>
                        <span style="font-size: 12px;">Qty: {{ $item->quantity }}</span>
                        @if ($item->remark)
                            <br><span style="font-size: 11px; color: #666;">Note: {{ $item->remark }}</span>
                        @endif
                    </td>
                    <td class="right w-30">
                        <span style="font-size: 12px;">₹{{ number_format($item->total_price, 2) }}</span>
                    </td>
                </tr>
                @php $addons = $item->getAddonDetails(); @endphp
                @foreach ($addons as $addon)
                    <tr>
                        <td class="w-70" style="padding-left:15px; font-size: 12px;">+ {{ $addon->name }}</td>
                        <td class="right w-30" style="font-size: 12px;">₹{{ number_format($addon->price, 2) }}</td>
                    </tr>
                @endforeach

                @if ($itemCount < $order->items->count())
                    <tr>
                        <td colspan="2" style="height: 4px;"></td>
                    </tr>
                @endif
            @endforeach
        </table>

        @if ($order->items->count() == 0)
            <div class="center muted" style="padding: 20px;">
                <strong>No items to prepare</strong><br>
                <small>No items found in this order</small>
            </div>
        @endif
        <div class="line"></div>
        <!-- Special Instructions -->
        @if ($order->remark)
            <div class="bold">Special Instructions:</div>
            <div style="font-size: 12px; margin-bottom: 8px;">{{ $order->remark }}</div>
            <div class="line"></div>
        @endif

        <!-- Footer -->
        <div class="center">
            <div class="bold">PREPARE FRESH & SERVE HOT!</div>
            <div class="mt-4 muted">
                Order #{{ $order->id }} • {{ $order->created_at->format('h:i A') }}
            </div>
        </div>

    </div>

</body>

</html>
