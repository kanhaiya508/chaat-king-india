<x-layouts.app title="Other Expenses">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard / Accounts /</span>
            Add Expense
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('other-expenses.store') }}" method="POST">
                    @csrf
                    @include('app.other_expenses._form')
                    <div class="mt-3 text-end">
                        <button class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
