<x-layouts.app title=" Role Management">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                @can('role-create')
                    <a href="{{ route('roles.create') }}">
                        <button type="button" class="btn btn-primary">Add</button>
                    </a>
                @endcan
            </div>
            <div class="card-body p-0">
                <div class="text-nowrap">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>


                                        @can('role-edit')
                                            <a class="btn btn-sm btn-warning me-1"
                                                href="{{ route('roles.edit', $row->id) }}"> <i class="fas fa-edit me-1"></i>
                                                Edit</a>
                                        @endcan
                                        @can('role-delete')
                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('roles.destroy', $row->id) }}"
                                                style="display:inline" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-button">
                                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</x-layouts.app>
