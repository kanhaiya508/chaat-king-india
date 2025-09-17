<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Form Card --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header border-bottom">
            <h5 class="mb-0 fw-semibold text-primary">
                {{ $isEditing ? 'Edit Slot' : 'Add New Slot' }}
            </h5>
        </div>
        <div class="card-body p-0">
            <form wire:submit.prevent="saveSlot" class="p-3">
                <div class="row g-3">

                    {{-- Start Time --}}
                    <div class="col-md-3">
                        <label class="form-label">Start Time</label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                               wire:model="start_time" step="60">
                        @error('start_time')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- End Time --}}
                    <div class="col-md-3">
                        <label class="form-label">End Time</label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                               wire:model="end_time" step="60">
                        @error('end_time')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Capacity --}}
                    <div class="col-md-2">
                        <label class="form-label">Capacity</label>
                        <input type="number" min="1" class="form-control @error('capacity') is-invalid @enderror"
                               wire:model="capacity">
                        @error('capacity')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" wire:model="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    {{-- Save Button --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-{{ $isEditing ? 'primary' : 'success' }} w-100">
                            {{ $isEditing ? 'Update' : 'Save' }}
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Slots List --}}
    <div class="row">
        @forelse($slots as $slot)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100 border-{{ $slot->is_active ? 'success' : 'secondary' }}">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">
                            {{ $slot->start_time }} - {{ $slot->end_time }}
                        </h5>
                        <p class="card-text mb-2">
                            <i class="fas fa-users me-1 text-muted"></i>
                            Capacity: <strong>{{ $slot->capacity }}</strong>
                        </p>
                        <span class="badge bg-{{ $slot->is_active ? 'success' : 'secondary' }}">
                            {{ $slot->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button wire:click="editSlot({{ $slot->id }})"
                                class="btn btn-sm btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                        <button wire:click="deleteSlot({{ $slot->id }})"
                                onclick="return confirm('Delete this slot?')"
                                class="btn btn-sm btn-danger">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-4">
                <i class="fas fa-clock fs-4 d-block mb-2"></i>
                No slots available.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $slots->links() }}
    </div>

</div>
