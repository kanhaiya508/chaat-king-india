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
            font-size: 14px;
            width: 280px;
            margin: 0 auto;
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
    </style>
</head>

<body onload="window.print()">

    @php
        $branch = $order->branch; // Branch relation
    @endphp

    <!-- KOT Header -->
    <div class="kot-header center bold">
        <div style="font-size: 16px;">KITCHEN ORDER TICKET</div>
        <div style="font-size: 12px;">{{ $branch->name ?? 'Your Store' }}</div>
    </div>

    <!-- Order Info -->
    <table>
        <tr>
            <td class="w-70"><strong>Order ID:</strong> #{{ $order->id }}</td>
            <td class="right w-30"><strong>{{ $order->type ? strtoupper($order->type) : '' }}</strong></td>
        </tr>
        <tr>
            <td><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</td>
            <td class="right">
                @if ($order->table)
                    <strong>Table:</strong> {{ $order->table->name }}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Customer:</strong> {{ $order->customer->name ?? 'Walk-in' }}
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- Items Only -->
    <div class="bold center" style="margin-bottom: 8px;">ITEMS TO PREPARE</div>
    
    <table>
        @foreach ($order->items as $item)
            <tr>
                <td class="w-70">
                    <strong>{{ $item->item_name }}</strong><br>
                    <span style="font-size: 12px;">Qty: {{ $item->quantity }}</span>
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
        @endforeach
    </table>

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

</body>

</html>
