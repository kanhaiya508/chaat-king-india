<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-4">

        <!-- Form Left Side -->
        <div class="col-md-4">
            <div class="card shadow-sm" style="max-width: 500px; margin: auto;">
                <div class="card-header border-bottom">
                    <h5 class="mb-0 fw-semibold text-primary">
                        {{ $isEditing ? 'Edit Table Category' : 'Add Table Category' }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <form wire:submit.prevent="saveTablecategory" class="p-3">
                        <!-- Table Category Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium text-dark">Table Category Name</label>
                            <input type="text" class="form-control shadow-sm" id="name"
                                wire:model.defer="name" placeholder="Enter table category name">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit"
                                class="btn shadow-sm btn-{{ $isEditing ? 'primary' : 'success' }}">
                                {{ $isEditing ? 'Update' : 'Add' }}
                            </button>

                            @if ($isEditing)
                                <button type="button" wire:click="resetForm"
                                    class="btn shadow-sm btn-outline-secondary">
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
                    <h5 class="mb-0 fw-semibold text-primary">Table Category List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tablecategories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button wire:click="editTablecategory({{ $category->id }})"
                                                    class="btn btn-sm btn-warning">
                                                    Edit
                                                </button>
                                                <button wire:click="deleteTablecategory({{ $category->id }})"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            No table categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-3">
                        {{ $tablecategories->links('livewire::bootstrap') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
