<x-layouts.app title="Other Expenses">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span>
            <span class="text-muted fw-light">Accounts /</span>
            Other Expenses
        </h4>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                @can('other-expense-create')
                    <a href="{{ route('other-expenses.create') }}" class="btn btn-primary">Add Expense</a>
                @endcan

                <!-- Search -->
                <form method="GET" class="mb-0">
                    <div class="input-group" style="max-width: 420px">
                        <input type="search" name="search" class="form-control" placeholder="Search Title"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="text-nowrap">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th style="width:60px">No</th>
                                <th>Title</th>
                                <th class="text-end" style="width:160px">Amount</th>
                                <th style="width:180px">Created At</th>
                                <th style="width:240px">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($expenses as $expense)
                                <tr>
                                    <td>{{ ($expenses->currentPage() - 1) * $expenses->perPage() + $loop->iteration }}</td>
                                    <td>{{ $expense->title }}</td>
                                    <td class="text-end">{{ number_format($expense->amount, 2) }}</td>
                                    <td>{{ $expense->created_at?->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @can('other-expense-view')
                                                <a class="btn btn-sm btn-info me-1"
                                                    href="{{ route('other-expenses.show', $expense->id) }}">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                            @endcan
                                            @can('other-expense-edit')
                                                <a class="btn btn-sm btn-warning me-1"
                                                    href="{{ route('other-expenses.edit', $expense->id) }}">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                            @endcan
                                            @can('other-expense-delete')
                                                <form method="POST"
                                                    action="{{ route('other-expenses.destroy', $expense->id) }}"
                                                    class="delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger delete-button">
                                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4">No expenses found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 px-3">
                        {{ $expenses->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.delete-button').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('Delete this expense? This action cannot be undone.')) {
                        this.closest('form').submit();
                    }
                });
            });
        </script>
    @endpush
</x-layouts.app>
