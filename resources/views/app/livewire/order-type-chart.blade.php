<div class="card shadow-sm h-100" wire:key="order-type-chart">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <div class="text-muted small">Orders by Type</div>
                <h5 class="mb-1 fw-bold">Order Mix</h5>
            </div>
            <span class="badge bg-primary">Total: {{ $chart['total'] }}</span>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-12">
                <canvas id="orderTypeChart"></canvas>
            </div>


        </div>
    </div>

    @once
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @endonce

    <script>
        (() => {
            const ctx = document.getElementById('orderTypeChart').getContext('2d');
            const labels = @json($chart['labels']);
            const counts = @json($chart['counts']);

            if (window.__orderTypeChart) {
                window.__orderTypeChart.destroy();
            }

            window.__orderTypeChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        data: counts
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const total = counts.reduce((a, b) => a + b, 0);
                                    const v = context.parsed;
                                    const pct = total ? ((v / total) * 100).toFixed(1) : 0;
                                    return `${context.label}: ${v} (${pct}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        })();
    </script>
</div>
