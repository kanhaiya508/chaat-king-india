<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-4">

        <!-- Form Left Side -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 fw-semibold text-primary">
                        {{ $isEditing ? 'Edit Table' : 'Add New Table' }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <form wire:submit.prevent="saveTable" class="p-3">
                        <!-- Table Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Table Name</label>
                            <input wire:model.defer="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror" id="name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Table Category -->
                        <div class="mb-3">
                            <label for="tablecategory_id" class="form-label">Table Category</label>
                            <select wire:model.defer="tablecategory_id"
                                    class="form-select @error('tablecategory_id') is-invalid @enderror"
                                    id="tablecategory_id">
                                <option value="">Select Category</option>
                                @foreach ($tablecategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('tablecategory_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit"
                                    class="btn btn-{{ $isEditing ? 'primary' : 'success' }}">
                                {{ $isEditing ? 'Update Table' : 'Add Table' }}
                            </button>

                            @if ($isEditing)
                                <button type="button" class="btn btn-outline-secondary" wire:click="resetForm">
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Right Side -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 fw-semibold text-primary">All Tables</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead >
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th style="width: 180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tables as $table)
                                    <tr>
                                        <td>{{ $table->name }}</td>
                                        <td>{{ $table->tablecategory->name ?? 'N/A' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button wire:click="editTable({{ $table->id }})"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </button>
                                                <button wire:click="deleteTable({{ $table->id }})"
                                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash me-1"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            No tables found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-3">
                        {{ $tables->links('livewire::bootstrap') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
