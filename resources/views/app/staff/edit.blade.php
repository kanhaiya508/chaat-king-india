<x-layouts.app title="Staff Management">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard / Staff /</span>
            Edit Staff
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                    @csrf @method('PUT')
                    @include('app.staff._form')
                    <div class="mt-3 text-end">
                        <button class="btn btn-primary"><i class="fa fa-save"></i> Update Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
