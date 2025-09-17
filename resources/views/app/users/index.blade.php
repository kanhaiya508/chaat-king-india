<x-layouts.app title="  User Management ">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header">
                @can('user-create')
                    <a href="{{ route('users.create') }}">
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
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Branches</th>
                                <th>Waiter Access</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>
                                        @if (!empty($row->getRoleNames()))
                                            @foreach ($row->getRoleNames() as $v)
                                                <label class="badge bg-primary">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->branches->isNotEmpty())
                                            @foreach ($row->branches as $branch)
                                                <label class="badge bg-info">{{ $branch->name }}</label>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No Branch</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->waiter_app_access)
                                            <span class="badge bg-success">Enabled</span>
                                        @else
                                            <span class="badge bg-secondary">Disabled</span>
                                        @endif
                                    </td>
                                    <td>


                                        <div class="d-flex">
                                            @can('user-edit')
                                                <!-- Edit Button -->
                                                <a class="btn btn-sm btn-warning me-1"
                                                    href="{{ route('users.edit', $row->id) }}">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                            @endcan
                                            @can('user-delete')
                                                <!-- Delete Button -->
                                                <form method="POST" action="{{ route('users.destroy', $row->id) }}"
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
                            @endforeach
                        </tbody>
                    </table>
                    {!! $data->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>


</x-layouts.app>
