{{-- resources/views/print/final-bill.blade.php --}}
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
                margin: 0;
                padding: 0;
                font-size: 18px;
                font-weight: bold;
            }

            @page {
                margin: 0 !important;
                size: auto;
            }

            .no-print {
                display: none !important;
            }

            /* Disable print backgrounds */
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .print-content {
                width: 100%;
                max-width: 280px;
                margin: 0 auto;
                padding: 0;
                text-align: center;
            }
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            text-align: center;
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
            font-size: 18px;
            font-weight: bold;
            border-collapse: collapse;
            margin: 0 auto;
        }

        td {
            vertical-align: top;
            padding: 1px 0;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .w-70 {
            width: 70%;
        }

        .w-50 {
            width: 50%;
        }

        .w-20 {
            width: 20%;
        }

        .w-15 {
            width: 15%;
        }

        .mt-4 {
            margin-top: 4px;
        }

        .mb-4 {
            margin-bottom: 4px;
        }

        .paid-badge {
            background-color: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="print-content">

        @php
            $branch = $order->branch; // Branch relation
            $paid = $order->payments->sum('amount');
            $byMode = $order->payments->groupBy('mode'); // ['cash','upi','card'...]
            $round = (float) ($order->round_off ?? 0);
            $write = (float) ($order->write_off ?? 0);
            
            // GST Calculation
            $subtotal = (float) $order->subtotal;
            $cgst = $subtotal * 0.025; // 2.5%
            $sgst = $subtotal * 0.025; // 2.5%
            $totalGST = $cgst + $sgst;
            $grandTotal = $subtotal + $totalGST; // Subtotal + GST
            
            $due = max(0, $grandTotal - $paid - $write);
        @endphp

        <!-- Header / Branch -->
        <div class="center bold">
            <div style="font-size: 16px;">{{ $branch->name ?? 'CHAAT KING' }}</div>
            <div style="font-size: 12px;">Shop no 3&4 D-Block Ranjit Avenue, Amritsar</div>
            <div style="font-size: 12px;">GST NO: {{ $branch->gst_number ?? '03ABDFK3778P1ZT' }}</div>
        </div>

        <div class="line"></div>

        <!-- Transaction Details -->
        <table>
            <tr>
                <td class="left">Name: {{ $order->customer->name ?? '' }}</td>
            </tr>
            <tr>
                <td class="left">Date: {{ $order->created_at->format('d/m/y H:i') }} |</td>
            </tr>
            <tr>
                <td class="left"> {{ $order->table->name ?? '9' }} |
                    {{ ucwords(str_replace('_', ' ', $order->type ?? 'dine_in')) }}</td>
            </tr>
            <tr>
                <td class="left">Cashier: {{ $order->staff->name ?? 'biller' }}</td>
            </tr>
            <tr>
                <td class="left">Bill No.: {{ $order->id }}</td>
            </tr>
        </table>

        <div class="line"></div>
        <!-- Items -->
        <table>
            <tr>
                <td class="w-50 left"><strong>Item</strong></td>
                <td class="w-15 center"><strong>Qty.</strong></td>
                <td class="w-20 right"><strong>Price</strong></td>
                <td class="w-15 right"><strong>Amount</strong></td>
            </tr>
            <tr>
                <td colspan="4" style="height: 2px;"></td>
            </tr>
            @foreach ($order->items as $item)
                <tr>
                    <td class="w-50 left">{{ $item->item_name }}</td>
                    <td class="w-15 center">{{ $item->quantity }}</td>
                    <td class="w-20 right">{{ number_format($item->price) }}</td>
                    <td class="w-15 right">{{ number_format($item->total_price) }}</td>
                </tr>
            @endforeach
        </table>

        <div class="line"></div>

        <!-- Summary -->
        <table>
            <tr>
                <td class="left"><strong>Total Qty</strong></td>
                <td class="right">{{ $order->items->sum('quantity') }}</td>
            </tr>
            <tr>
                <td class="left"><strong>Sub Total</strong></td>
                <td class="right">{{ number_format($order->subtotal) }}</td>
            </tr>
            <tr>
                <td class="left"><strong>CGST@ 2.5%</strong></td>
                <td class="right">{{ number_format($cgst) }}</td>
            </tr>
            <tr>    
                <td class="left"><strong>SGST@ 2.5%</strong></td>
                <td class="right">{{ number_format($sgst) }}</td>
            </tr>
        </table>

        <div class="line"></div>
        <!-- Grand Total -->
        <table>
            <tr>
                <td><strong>Grand Total:</strong></td>
                <td class="right"><strong>₹{{ number_format($grandTotal) }}</strong></td>
            </tr>
        </table>

        <div class="line"></div>
       
        <!-- Footer -->
        <div class="center">
            <div style="font-size: 14px;"><strong>Thanks</strong></div>
        </div>

    </div>

</body>

</html>
