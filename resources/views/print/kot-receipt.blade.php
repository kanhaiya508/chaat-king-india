{{-- resources/views/print/kot-receipt.blade.php --}}
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
                font-size: 12px;
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
            font-size: 12px;
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

        .w-50 {
            width: 50%;
        }

        .w-25 {
            width: 25%;
        }

        .mt-4 {
            margin-top: 2px;
        }

        .mb-4 {
            margin-bottom: 2px;
        }

        .kot-header {
            background-color: #f0f0f0;
            padding: 8px;
            margin-bottom: 8px;
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

<body onload="window.print()" style="margin: 0; padding: 0;">

    <div class="print-content">

        @php
            $branch = $order->branch; // Branch relation
        @endphp

        <!-- Header -->
        <div class="center bold">
            <div style="font-size: 14px;">Running Table</div>
            <div style="font-size: 10px;">{{ $order->created_at->format('d/m/y H:i') }}</div>
            <div style="font-size: 12px;">KOT - {{ $order->id }}</div>
            <div style="font-size: 10px;">{{ $order->type ?? 'Dine In' }}</div>
            <div style="font-size: 10px;">Table No: {{ $order->table->name ?? 'N/A' }}</div>
        </div>

        <div class="line"></div>

        <!-- Items Table -->
        <table>
            <tr>
                <td class="w-50"><strong>Item</strong></td>
                <td class="w-25 center"><strong>Special Note</strong></td>
                <td class="w-25 right"><strong>Qty.</strong></td>
            </tr>
            <tr>
                <td colspan="3" style="height: 2px;"></td>
            </tr>
            @foreach ($order->items as $item)
                <tr>
                    <td class="w-50">{{ $item->item_name }}</td>
                    <td class="w-25 center">{{ $item->remark ?: '--' }}</td>
                    <td class="w-25 right">{{ $item->quantity }}</td>
                </tr>
                @php $addons = $item->getAddonDetails(); @endphp
                @foreach ($addons as $addon)
                    <tr>
                        <td class="w-50" style="padding-left:10px;">+ {{ $addon->name }}</td>
                        <td class="w-25 center">--</td>
                        <td class="w-25 right">{{ $addon->quantity ?? 1 }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>

    </div>

</body>

</html>

