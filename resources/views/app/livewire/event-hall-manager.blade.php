<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Card for Form --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header border-bottom">
            <h5 class="mb-0 fw-semibold text-primary">
                {{ $isEditing ? 'Edit Event Hall' : 'Add Event Hall' }}
            </h5>
        </div>
        <div class="card-body p-0">
            <form wire:submit.prevent="saveEventHall" class="p-3">
                <div class="row g-3">

                    {{-- Name --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Event Hall Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter hall name" wire:model="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Slots --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Select Slots</label>
                        <select class="form-select js-example-basic-multiple-limit" wire:model="selectedSlots" multiple
                            size="6">
                            @foreach ($allSlots as $slot)
                                <option value="{{ $slot->id }}">
                                    {{ $slot->start_time }} - {{ $slot->end_time }}
                                    (Cap: {{ $slot->capacity }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-1">
                            Hold <kbd>Ctrl</kbd> (Windows) or <kbd>Command</kbd> (Mac) to select multiple slots.
                        </small>
                    </div>

                    {{-- Save button --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-{{ $isEditing ? 'primary' : 'success' }} w-100">
                            {{ $isEditing ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Card for Table --}}
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="mb-0 fw-semibold text-primary">Event Halls</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead >
                        <tr>
                            <th>Name</th>
                            <th>Slots</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eventHalls as $hall)
                            <tr>
                                <td class="fw-semibold">{{ $hall->name }}</td>
                                <td>
                                    @if ($hall->slots->count())
                                        @foreach ($hall->slots as $slot)
                                            <span class="badge bg-primary me-1">
                                                {{ $slot->start_time }} - {{ $slot->end_time }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No slots assigned</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button wire:click="editEventHall({{ $hall->id }})"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </button>
                                        <button wire:click="deleteEventHall({{ $hall->id }})"
                                            onclick="return confirm('Delete this event hall?')"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    No event halls available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($eventHalls->hasPages())
            <div class="card-footer">
                {{ $eventHalls->links() }}
            </div>
        @endif
    </div>

</div>
