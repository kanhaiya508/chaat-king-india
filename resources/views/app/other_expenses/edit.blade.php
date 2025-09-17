<x-layouts.app title="Other Expenses">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard / Accounts /</span>
            Edit Expense
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('other-expenses.update', $otherExpense->id) }}" method="POST">
                    @csrf @method('PUT')
                    @include('app.other_expenses._form', ['expense' => $otherExpense])
                    <div class="mt-3 text-end">
                        <button class="btn btn-primary">
                            <i class="fa fa-save"></i> Update Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
