<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order #{{ $order->id }} • {{ $order->branch->name ?? 'Store' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                max-width: 200px;
                margin: 0;
                padding: 0;
            }
        }
        
        :root {
            --muted: #666;
            --line: #e6e6e6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            margin: 0;
            background: #fafafa;
            color: #111;
        }

        .wrap {
            max-width: 720px;
            margin: 16px auto;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            overflow: hidden;
        }

        header {
            padding: 14px 16px;
            text-align: center;
            border-bottom: 1px solid var(--line);
        }

        header .title {
            font-weight: 700;
            font-size: 18px;
        }

        header .sub {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.4;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            padding: 16px;
        }

        @media(min-width:720px) {
            .grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px;
        }

        .card h3 {
            margin: 0 0 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            font-size: 14px;
            padding: 6px 0;
            border-bottom: 1px dashed #eee;
        }

        .row:last-child {
            border-bottom: none;
        }

        .muted {
            color: var(--muted);
        }

        .right {
            text-align: right;
        }

        .tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .tbl th,
        .tbl td {
            padding: 8px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
        }

        .tbl th {
            text-align: left;
            font-size: 12px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 12px;
            background: #f2f2f2;
        }

        .success {
            background: #e8f7ec;
        }

        .warning {
            background: #fff6e5;
        }

        .danger {
            background: #fdecec;
        }

        .total {
            font-weight: 700;
        }

        .copy {
            display: inline-flex;
            gap: 8px;
            align-items: center;
            padding: 6px 10px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fafafa;
            cursor: pointer;
        }

        footer {
            text-align: center;
            padding: 14px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 12px;
        }

        .small {
            font-size: 12px;
        }

        .pill {
            padding: 2px 6px;
            border-radius: 6px;
            background: #f5f5f5;
        }
    </style>
</head>

<body>

    <div class="wrap">

        {{-- HEADER / BRANCH --}}
        <header>
            <div class="title">{{ $order->branch->name ?? 'Your Store' }}</div>
            <div class="sub">
                {{ $order->branch->address ?? '' }}<br>
                @if ($order->branch?->contact_number)
                    Phone: {{ $order->branch->contact_number }} •
                @endif
                @if ($order->branch?->gst_number)
                    GSTIN: {{ $order->branch->gst_number }}
                @endif
            </div>
        </header>

        {{-- META + CUSTOMER + STATUS --}}
        <div class="grid">
            <div class="card">
                <h3>Order</h3>
                <div class="row">
                    <div>Order ID</div>
                    <div class="right">#{{ $order->id }}</div>
                </div>
                <div class="row">
                    <div>Date</div>
                    <div class="right">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                </div>
                <div class="row">
                    <div>Updated</div>
                    <div class="right">{{ $order->updated_at?->format('d M Y, h:i A') }}</div>
                </div>
                <div class="row">
                    <div>Type</div>
                    <div class="right">
                        <span class="badge">{{ strtoupper($order->type ?? 'NA') }}</span>
                    </div>
                </div>
                <div class="row">
                    <div>Status</div>
                    <div class="right">
                        @php
                            $paid = (bool) ($order->is_paid ?? false);
                            $st = $order->status ?? 'pending';
                        @endphp
                        <span class="badge {{ $paid ? 'success' : 'warning' }}">{{ $paid ? 'PAID' : 'UNPAID' }}</span>
                        <span class="badge">{{ strtoupper($st) }}</span>
                    </div>
                </div>
                <div class="row">
                    <div>Table</div>
                    <div class="right">
                        @if (method_exists($order, 'table') && $order->relationLoaded('table') && $order->table)
                            {{ $order->table->name }}
                        @else
                            {{ $order->table_id ? '#' . $order->table_id : '—' }}
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div>Staff</div>
                    <div class="right">{{ $order->staff->name ?? '—' }}</div>
                </div>
            </div>

            <div class="card">
                <h3>Customer</h3>
                <div class="row">
                    <div>Name</div>
                    <div class="right">{{ $order->customer->name ?? 'Walk-in' }}</div>
                </div>
                <div class="row">
                    <div>Phone</div>
                    <div class="right">{{ $order->customer->phone ?? '—' }}</div>
                </div>
                <div class="row">
                    <div>Remark</div>
                    <div class="right">{{ $order->remark ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- DELIVERY (optional) --}}
        @if ($order->delivery_partner_name || $order->delivery_location || $order->delivery_distance)
            <div class="grid">
                <div class="card" style="grid-column:1 / -1;">
                    <h3>Delivery</h3>
                    <div class="row">
                        <div>Partner</div>
                        <div class="right">
                            {{ $order->delivery_partner_name ?? '—' }}
                            @if ($order->delivery_partner_phone)
                                <span class="pill">{{ $order->delivery_partner_phone }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div>Location</div>
                        <div class="right">{{ $order->delivery_location ?? '—' }}</div>
                    </div>
                    <div class="row">
                        <div>Distance</div>
                        <div class="right">{{ $order->delivery_distance ? $order->delivery_distance . ' km' : '—' }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ITEMS + ADDONS --}}
        <div class="grid">
            <div class="card" style="grid-column:1 / -1;">
                <h3>Items</h3>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th style="width:55%;">Item</th>
                            <th>Qty</th>
                            <th class="right">Rate</th>
                            <th class="right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->item_name }}</strong>
                                    @php $addons = $item->getAddonDetails(); @endphp
                                    @if (!empty($addons))
                                        <div class="small muted">
                                            @foreach ($addons as $addon)
                                                • {{ $addon->name }} (₹{{ number_format($addon->price, 2) }})<br>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td class="right">₹{{ number_format($item->price, 2) }}</td>
                                <td class="right">₹{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TOTALS BLOCK --}}
        @php
            $round = (float) ($order->round_off ?? 0);
            $write = (float) ($order->write_off ?? 0);
            $paidAmt = (float) $order->payments->sum('amount');
            $grand = (float) $order->total;
            $due = max(0, $grand - $paidAmt - $write);
        @endphp

        <div class="grid">
            <div class="card">
                <h3>Bill Summary</h3>
                <div class="row">
                    <div>Subtotal</div>
                    <div class="right">₹{{ number_format($order->subtotal, 2) }}</div>
                </div>
                <div class="row">
                    <div>Discount</div>
                    <div class="right">- ₹{{ number_format($order->discount, 2) }}</div>
                </div>

                @if (abs($round) > 0.0001)
                    <div class="row">
                        <div>Round Off</div>
                        <div class="right">{{ $round >= 0 ? '+' : '-' }} ₹{{ number_format(abs($round), 2) }}</div>
                    </div>
                @endif

                <div class="row total">
                    <div>Total</div>
                    <div class="right">₹{{ number_format($grand, 2) }}</div>
                </div>

                @if ($write > 0)
                    <div class="row">
                        <div>Write-off</div>
                        <div class="right">₹{{ number_format($write, 2) }}</div>
                    </div>
                    @if ($order->write_off_reason)
                        <div class="row">
                            <div class="muted">Reason</div>
                            <div class="right muted">{{ $order->write_off_reason }}</div>
                        </div>
                    @endif
                @endif

                <div class="row">
                    <div>Amount Paid</div>
                    <div class="right">₹{{ number_format($paidAmt, 2) }}</div>
                </div>
                <div class="row total">
                    <div>Balance Due</div>
                    <div class="right">₹{{ number_format($due, 2) }}</div>
                </div>
            </div>

            {{-- PAYMENT MODE SPLIT --}}
            <div class="card">
                <h3>Payment Modes</h3>
                @php $byMode = $order->payments->groupBy('mode'); @endphp
                @forelse($byMode as $mode => $rows)
                    @php $amt = $rows->sum('amount'); @endphp
                    <div class="row">
                        <div>{{ strtoupper($mode ?: 'N/A') }}</div>
                        <div class="right">₹{{ number_format($amt, 2) }}</div>
                    </div>
                @empty
                    <div class="muted">No payments recorded.</div>
                @endforelse
            </div>
        </div>

        {{-- PAYMENTS TIMELINE --}}
        <div class="grid">
            <div class="card" style="grid-column:1 / -1;">
                <h3>Payments Timeline</h3>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Mode</th>
                            <th>Reference</th>
                            <th class="right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->payments->sortBy('created_at') as $p)
                            <tr>
                                <td class="small">{{ $p->created_at?->format('d M Y, h:i A') }}</td>
                                <td>{{ strtoupper($p->mode ?? 'N/A') }}</td>
                                <td class="small">{{ $p->reference ?? '—' }}</td>
                                <td class="right">₹{{ number_format($p->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="muted">No payments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SHARE LINK + ACTIONS --}}
        <div class="grid">
            <div class="card" style="grid-column:1 / -1;">
                <h3>Share</h3>
                <div class="row">
                    <div class="muted">Public Link</div>
                    <div class="right small">
                        <a id="shareLink" href="{{ route('orders.share', $order->id) }}">
                            {{ route('orders.share', $order->id) }}
                        </a>
                    </div>
                </div>
                <div style="display:flex; gap:8px; margin-top:8px;">
                    <button class="copy" onclick="copyShare()">Copy Link</button>
                    @php
                        $waText = rawurlencode(
                            'Bill for Order #' . $order->id . ' - ' . route('orders.share', $order->id),
                        );
                    @endphp
                    <a class="copy" href="https://wa.me/?text={{ $waText }}" target="_blank"
                        rel="noopener">Share on WhatsApp</a>
                </div>
            </div>
        </div>

        <footer>
            Generated on {{ now()->format('d M Y, h:i A') }} • {{ $order->branch->name ?? 'Store' }}
        </footer>
    </div>

    <script>
        function copyShare() {
            const link = document.getElementById('shareLink').href;
            navigator.clipboard.writeText(link).then(() => {
                alert('Link copied!');
            });
        }
    </script>

</body>

</html>
