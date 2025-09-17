<x-layouts.app title="  Branches Management ">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> <span
                class="text-muted fw-light">Branches /</span> List</h4>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                @can('branche-create')
                    <a href="{{ route('branches.create') }}" class="btn btn-primary">Add Branch</a>
                @endcan
                <!-- Search -->
                <form method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control" placeholder="Search Branch Name"
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
                                <th>Contact</th>
                                <th>GST</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($branches as $branch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->contact_number }}</td>
                                    <td>{{ $branch->gst_number }}</td>
                                    <td>
                                        <span class="badge bg-{{ $branch->is_active ? 'success' : 'danger' }}">
                                            {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $branch->created_at->format('d M Y') }}</td>
                                    <td>


                                        <div class="d-flex">
                                            @can('branche-edit')
                                                <!-- Edit Button -->
                                                <a class="btn btn-sm btn-warning me-1"
                                                    href="{{ route('branches.edit', $branch->id) }}">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                            @endcan
                                            @can('branche-delete')
                                                <!-- Delete Button -->
                                                <form method="POST" action="{{ route('branches.destroy', $branch->id) }}"
                                                    style="display:inline" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger delete-button">
                                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endcan


                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Branches Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $branches->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
