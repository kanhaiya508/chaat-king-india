<div>
    {{-- Filters --}}
    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
        @php
            $opts = [
                'today' => 'Today',
                'week' => 'This Week',
                'month' => 'This Month',
                'year' => 'This Year',
                'custom' => 'Custom',
            ];
        @endphp
        @foreach ($opts as $key => $label)
            <button wire:click="setRange('{{ $key }}')"
                class="btn {{ $range === $key ? 'btn-danger' : 'btn-primary' }} btn-sm">
                {{ $label }}
            </button>
        @endforeach

        {{-- Custom Date Inputs --}}
        @if ($range === 'custom')
            <div class="d-flex align-items-center gap-2 ms-3">
                <input type="date" wire:model.live="fromDate" class="form-control form-control-sm">
                <span>to</span>
                <input type="date" wire:model.live="toDate" class="form-control form-control-sm">
            </div>
        @endif

        <div class="ms-auto small text-muted align-self-center">
            Range: {{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}
        </div>
    </div>

    {{-- Summary cards --}}
    <div class="row g-3">


        {{-- 2) Gross Billed (दूसरा) --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="mb-1 fw-bold text-primary">Gross Billed</h5>
                        <span class="badge bg-danger text-white">calc</span>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Amount</div>
                            <div class="h4 mb-0  text-primary">₹ {{ number_format($grossBilled, 2) }}</div>
                        </div>
                        <img src="{{ asset('icone/billed.png') }}" onerror="this.style.display='none';"
                            alt="Gross Billed" style="height:80px;width:80px;object-fit:contain;">
                    </div>
                </div>
            </div>
        </div>

        {{-- 1) Total Collected (पहला) --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="mb-1 text-primary fw-bold">Total Collected</h5>
                        <span class="badge bg-success">{{ $grandCount }} payments</span>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Amount</div>
                            <div class="h4 mb-0 text-primary">₹ {{ number_format($grandTotal, 2) }}</div>
                        </div>
                        <img src="{{ asset('icone/sales.png') }}" alt="Total Collected"
                            style="height:80px;width:80px;object-fit:contain;">
                    </div>
                </div>
            </div>
        </div>



        {{-- 3) Net After Expenses (तीसरा) --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="mb-1 text-primary fw-bold">Net After Expenses</h5>
                        <span class="badge bg-danger text-white">calc</span>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Collected − Expenses</div>
                            <div class="h4 mb-0 text-primary">₹ {{ number_format($netAfterExpenses, 2) }}</div>
                        </div>
                        <img src="{{ asset('icone/net.png') }}" onerror="this.style.display='none';" alt="Net"
                            style="height:80px;width:80px;object-fit:contain;">
                    </div>
                </div>
            </div>
        </div>

        {{-- 4) Discount (Row-2, पहले) --}}
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="mb-1 fw-bold text-primary">Discount</h5>
                        <span class="badge bg-danger text-white">{{ $writeOffOrders }} orders</span>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Amount</div>
                            <div class="h4 mb-0 text-primary">₹ {{ number_format($discountTotal, 2) }}</div>
                        </div>
                        <img src="{{ asset('icone/discount.png') }}" onerror="this.style.display='none';"
                            alt="Discount" style="height:80px;width:80px;object-fit:contain;">
                    </div>
                </div>
            </div>
        </div>

        {{-- 5) Waived Off (Row-2, दूसरा) --}}
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="mb-1 text-primary fw-bold">Waived Off </h5>
                        <span class="badge bg-danger text-white">{{ $grandCount }} orders</span>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Amount</div>
                            <div class="h4 mb-0 text-primary">₹ {{ number_format($writeOffTotal, 2) }}</div>
                        </div>
                        <img src="{{ asset('icone/writeoff.png') }}" onerror="this.style.display='none';"
                            alt="Write-off" style="height:80px;width:80px;object-fit:contain;">
                    </div>
                </div>
            </div>
        </div>

        {{-- 6) Marked Paid (No Amount) (Row-2, तीसरा) --}}
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="mb-1 fw-bold text-primary">Marked Paid (No Amount)</h5>
                        <span class="badge bg-danger text-white">{{ $paidNoAmountCount }} orders</span>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Amount</div>
                            <div class="h4 mb-0 text-primary">₹ {{ number_format($paidNoAmountTotal, 2) }}</div>
                        </div>
                        <img src="{{ asset('icone/paid.png') }}" onerror="this.style.display='none';"
                            alt="No Amount Paid" style="height:80px;width:80px;object-fit:contain;">
                    </div>
                </div>
            </div>
        </div>

        {{-- 7) Expenses (Row-3, full/half जैसा पहले है) --}}
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="mb-1 text-primary fw-bold">Expenses</h5>
                        <span class="badge bg-danger text-white">{{ $expenseCount }} entries</span>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Amount</div>
                            <div class="h4 mb-0 text-primary">₹ {{ number_format($expenseTotal, 2) }}</div>
                        </div>
                        <img src="{{ asset('icone/expenses.png') }}" onerror="this.style.display='none';"
                            alt="Expenses" style="height:100px;width:80px;object-fit:contain;">
                    </div>
                </div>
            </div>
        </div>

        {{-- 8) Modes (जैसे हैं वैसे रखें) --}}
        @foreach ($cards as $mode => $data)
            <div class="col-12 col-md-4">
                <div class="card shadow-sm ">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-muted small">Mode</div>
                                <h5 class="mb-1 text-primary fw-bold">{{ $data['mode'] }}</h5>
                            </div>
                            <span class="badge bg-danger text-white">{{ $data['count'] }} tx</span>
                        </div>
                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Amount</div>
                                <div class="h4 mb-0  fw-semibold text-primary ">₹
                                    {{ number_format($data['total'], 2) }}</div>
                            </div>
                            <img src="{{ asset('icone/' . strtolower($data['mode']) . '.png') }}"
                                alt="{{ $data['mode'] }}" style="height:80px; width:80px; object-fit:contain;">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>


</div>
