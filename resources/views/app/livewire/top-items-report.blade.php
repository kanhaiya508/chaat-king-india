<div class="card shadow-sm h-100" wire:key="top-items-report">
    <div class="card-body">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 text-muted small">
                    <i class="ri-bar-chart-2-line"></i>
                    <span>Most Ordered Items</span>
                </div>
                <h5 class="mb-1 fw-bold">Top {{ $report['rows']->count() }} Items</h5>
                <div class="text-muted small">Total Qty in list: {{ $report['totalQty'] }}</div>
            </div>

            {{-- mini stat cards --}}
            <div class="d-flex gap-2">
                <div class="card border-0 ">
                    <div class="card-body p-2 px-3">
                        <div class="small text-muted mb-1">Total Items</div>
                        <div class="h6 m-0">{{ $report['rows']->count() }}</div>
                    </div>
                </div>
                <div class="card border-0 ">
                    <div class="card-body p-2 px-3">
                        <div class="small text-muted mb-1">Total Qty</div>
                        <div class="h6 m-0">{{ $report['totalQty'] }}</div>
                    </div>
                </div>
                <div class="card border-0 ">
                    <div class="card-body p-2 px-3">
                        <div class="small text-muted mb-1">Top 1 Qty</div>
                        <div class="h6 m-0">
                            {{ $report['rows']->first() ? (int) $report['rows']->first()->total_qty : 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($report['rows']->isEmpty())
            <div class="alert alert-warning mb-0">No data available.</div>
        @else
            <div class="row g-3">
                {{-- Chart --}}
                <div class="col-12 col-md-6">
                    <div class="border rounded-3 p-2 h-100 d-flex align-items-center">
                        <canvas id="topItemsChart" style="min-height: 280px;"></canvas>
                    </div>
                </div>

                {{-- Table --}}
                <div class="col-12 col-md-6">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm align-middle mb-0">
                            <thead class="">
                                <tr>
                                    <th style="width:50px;">#</th>
                                    <th>Item</th>
                                    <th class="text-end" style="width:100px;">Qty</th>
                                    <th class="text-end" style="width:110px;">Orders</th>
                                    <th class="text-end" style="width:140px;">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report['rows'] as $i => $row)
                                    @php
                                        $pct = $report['totalQty'] ? round(100 * ((int)$row->total_qty) / $report['totalQty']) : 0;
                                    @endphp
                                    <tr>
                                        <td class="text-muted">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold text-truncate" style="max-width: 260px;">
                                                {{ $row->name }}
                                            </div>
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: {{ $pct }}%;"
                                                     aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $pct }}%</small>
                                        </td>
                                        <td class="text-end fw-semibold">{{ (int) $row->total_qty }}</td>
                                        <td class="text-end">{{ (int) $row->orders_count }}</td>
                                        <td class="text-end">₹ {{ number_format((float) $row->total_revenue, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- callouts --}}
                    <div class="d-flex gap-2 mt-3">
                        @if($report['rows']->first())
                            <span class="badge bg-primary-subtle text-primary">
                                ⭐ Top: {{ $report['rows']->first()->name }}
                            </span>
                        @endif
                        <span class="badge bg-secondary-subtle text-secondary">
                            Showing {{ $report['rows']->count() }} items
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @once
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @endonce

    <script>
        (() => {
            const el = document.getElementById('topItemsChart');
            if (!el) return;

            const labels = @json($report['labels']);
            const qtys   = @json($report['qtys']);

            if (window.__topItemsChart) window.__topItemsChart.destroy();

            window.__topItemsChart = new Chart(el.getContext('2d'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{ label: 'Quantity', data: qtys }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: (ctx) => `Qty: ${ctx.parsed.x}` } }
                    },
                    scales: {
                        x: { beginAtZero: true, grid: { display: false } },
                        y: { ticks: { autoSkip: false }, grid: { display: false } }
                    }
                }
            });
        })();
    </script>
</div>
