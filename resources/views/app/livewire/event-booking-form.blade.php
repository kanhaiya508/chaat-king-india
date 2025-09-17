<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6">
            <div class="card  ">
                <div class="card-header  text-white rounded-top-4">
                    <h5 class="mb-0 fw-bold">
                        Booking Form
                    </h5>
                </div>

                <div class="card-body">
                    {{-- Date & Hall Selection --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Select Date</label>
                            <input type="date" class="form-control shadow-sm" wire:model.live="booking_date">
                            @error('booking_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Select Event Hall</label>
                            <select class="form-select shadow-sm" wire:model.live="selectedHall">
                                <option value="">-- Select Hall --</option>
                                @foreach ($eventHalls as $hall)
                                    <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                                @endforeach
                            </select>
                            @error('selectedHall')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Slot Cards --}}
                    @if ($booking_date && $selectedHall)
                        <h5 class="fw-bold mb-3">Available Slots</h5>
                        <div class="row g-3">
                            @foreach ($slots as $slot)
                                <div class="col-md-3">
                                    <div class="card slot-card shadow-sm
                    {{ in_array($slot->id, $bookedSlots) ? 'border-secondary bg-light' : 'border-primary' }}"
                                        style="cursor: pointer;" wire:click="$set('selectedSlot', {{ $slot->id }})"
                                        @if (in_array($slot->id, $bookedSlots)) wire:click.prevent @endif>
                                        <div class="card-body text-center">
                                            <h6 class="fw-bold text-primary">
                                                {{ $slot->start_time }} - {{ $slot->end_time }}
                                            </h6>
                                            <p class="mb-2 text-muted small">Capacity: {{ $slot->capacity }}</p>
                                            @if (in_array($slot->id, $bookedSlots))
                                                <span class="badge bg-secondary">Booked</span>
                                            @elseif ($selectedSlot == $slot->id)
                                                <span class="badge bg-success">Selected</span>
                                            @else
                                                <span class="badge bg-outline-primary">Available</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('selectedSlot')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    @endif

                    {{-- Remark + Save --}}
                    @if ($selectedSlot)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Remark</label>
                                <textarea class="form-control shadow-sm" wire:model="remark" placeholder="Enter remark (optional)" rows="3"></textarea>
                                @error('remark')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-success shadow-sm" wire:click="saveBooking">
                                Save Booking
                            </button>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card ">
                <div class="card-header  text-white rounded-top-4">
                    <h5 class="mb-0 fw-bold">
                        All Event Bookings
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Booking List --}}
                    @if ($bookings && count($bookings) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-dark">
                                    <tr>
                                        <th class="px-4 text-white py-3">Date</th>
                                        <th class="px-4 text-white py-3">Hall</th>
                                        <th class="px-4 text-white py-3">Slot</th>
                                        <th class="px-4 text-white py-3">Remark</th>
                                        <th class="px-4 text-white py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td class="px-4">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                            </td>
                                            <td class="px-4">{{ $booking->eventHall->name }}</td>
                                            <td class="px-4">
                                                <span class="badge bg-info text-dark">
                                                    {{ $booking->slot->start_time }} - {{ $booking->slot->end_time }}
                                                </span>
                                            </td>
                                            <td class="px-4">{{ $booking->remark ?? '—' }}</td>
                                            <td class="px-4 text-center">
                                                <button wire:click="deleteBooking({{ $booking->id }})"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this booking?')">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            border  <i class="fas fa-info-circle fs-4"></i>
                            <p class="mb-0">No bookings available</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>


</div>
