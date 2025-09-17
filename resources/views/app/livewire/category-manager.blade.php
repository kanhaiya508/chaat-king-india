<!-- Main Layout -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-4">

        <!-- Form Left Side -->
        <div class="col-md-4">
            <div class="card ">
                <div class="card-header ">
                    <h5 class="mb-0 fw-semibold text-primary">
                        {{ $isEditing ? 'Edit Category' : 'Add Category' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveCategory">

                        <!-- Category Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium text-dark">Category Name</label>
                            <input type="text" class="form-control shadow-sm @error('name') is-invalid @enderror"
                                id="name" wire:model.defer="name" placeholder="Enter category name">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn shadow-sm btn-primary">
                                {{ $isEditing ? 'Update Category' : 'Add Category' }}
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
            <div class="card p-0">
                <div class="card-header ">
                    <h5 class="mb-0 fw-semibold text-primary">Category List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead >
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button wire:click="editCategory({{ $category->id }})"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </button>
                                                <button wire:click="deleteCategory({{ $category->id }})"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                                                    <i class="fas fa-trash me-1"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            No categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $categories->links('livewire::bootstrap') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
