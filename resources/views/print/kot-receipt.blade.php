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
            font-size: 14px;
            font-weight: bold;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            text-align: center;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 100%;
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
            white-space: nowrap;
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

        .w-25 {
            width: 25%;
        }

        .w-20 {
            width: 20%;
        }

        .w-30 {
            width: 30%;
        }

        .w-10 {
            width: 10%;
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
            margin: 0 auto;
            padding: 0;
            width: 100%;
            max-width: 280px;
            background: white;
            text-align: center;
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
            <div style="font-size: 14px; text-align: center;">{{ $order->created_at->format('d/m/y H:i') }}</div>
            <div style="font-size: 14px; text-align: center;">KOT - {{ $order->id }}</div>
            <div style="font-size: 18px; text-align: center;">
                {{ ucwords(str_replace('_', ' ', $order->type ?? 'dine_in')) }}</div>
            <div style="font-size: 18px; text-align: center;">Table No: {{ $order->table->name ?? 'N/A' }}</div>
        </div>

        <div class="line"></div>

        <!-- Items Table -->
        <table>
            <tr>
                <td class="w-50 left " style="font-weight: normal; font-size: 14px;">Item</td>
                <td class="w-30 center" style="font-weight: normal; font-size: 12px; white-space: nowrap;">Special Note</td>
                <td class="w-20 right " style="font-weight: normal; font-size: 14px;">Qty.</td>
            </tr>
            <tr>
                <td colspan="3" style="height: 2px;"></td>
            </tr>
            @foreach ($order->items as $item)
                <tr>
                    <td class="w-50 left">{{ $item->item_name }}</td>
                    <td class="w-30 center">{{ $item->remark ?: '--' }}</td>
                    <td class="w-20 right">{{ $item->quantity }}</td>
                </tr>
                @php $addons = $item->getAddonDetails(); @endphp
                @foreach ($addons as $addon)
                    <tr>
                        <td class="w-50 left">+ {{ $addon->name }}</td>
                        <td class="w-30 center"></td>
                        <td class="w-20 right"></td>
                    </tr>
                @endforeach
            @endforeach
        </table>

    </div>

</body>

</html>
