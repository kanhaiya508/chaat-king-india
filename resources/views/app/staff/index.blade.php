<x-layouts.app title="Staff Management">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> <span
                class="text-muted fw-light">Staff /</span> List</h4>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                @can('staff-create')
                    <a href="{{ route('staff.create') }}" class="btn btn-primary">Add Staff</a>
                @endcan
                <!-- Search -->
                <form method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control" placeholder="Search Staff Name"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="text-nowrap">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Father Name</th>
                                <th>Phone</th>
                                <th>Aadhaar</th>
                                <th>Designation</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($staff as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->father_name }}</td>
                                    <td>{{ $member->phone }}</td>
                                    <td>{{ $member->aadhaar_number }}</td>
                                    <td>{{ $member->designation }}</td>
                                    <td>{{ $member->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @can('staff-edit')
                                                <a class="btn btn-sm btn-warning me-1"
                                                    href="{{ route('staff.edit', $member->id) }}">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                            @endcan
                                            @can('staff-delete')
                                                <form method="POST" action="{{ route('staff.destroy', $member->id) }}"
                                                    style="display:inline" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
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
                                    <td colspan="8" class="text-center">No Staff Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $staff->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
