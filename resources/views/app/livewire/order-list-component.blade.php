  <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row g-6">
          <div class="card p-0">
              <h5 class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
                  <span>Orders</span>

                  <div class="d-flex gap-2">
                      <!-- Type Filter -->
                      <select class="form-select form-select-sm w-auto" wire:model.live="type">
                          <option value="">All types</option>
                          <option value="takeaway">Takeaway</option>
                          <option value="delivery">Delivery</option>
                          <option value="dine-in">Dine-in</option>
                      </select>

                      <!-- Search -->
                      <input type="text" class="form-control form-control-sm w-auto" wire:model.lazy="search"
                          placeholder="Search by ID / Name / Phone" />
                  </div>
              </h5>
              <div class="table-responsive text-nowrap">
                  <table class="table align-middle">
                      <thead>
                          <tr>
                              <th>Order #</th>
                              <th>Customer</th>
                              <th>Phone</th>
                              <th>Total</th>
                              <th>Remark</th>
                              <th>Date</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          @forelse ($orders as $order)
                              <tr>
                                  <td><strong>#{{ $order->id }}</strong></td>
                                  <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                  <td>{{ $order->customer->phone ?? 'N/A' }}</td>
                                  <td>₹{{ number_format($order->total, 2) }}</td>
                                  <td>{{ $order->remark ?? '-' }}</td>
                                  <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                  <td>
                                      <!-- WhatsApp Share (direct order link) -->
                                      <a class="btn btn-sm btn-outline-success me-1"
                                          href="https://wa.me/?text={{ urlencode('Bill for Order #' . $order->id . ' - ' . route('orders.share', $order->id)) }}"
                                          target="_blank">
                                          <i class="fab fa-whatsapp"></i>
                                      </a>

                                      <!-- Copy Share Link -->
                                      <button class="btn btn-sm btn-outline-secondary me-1"
                                          onclick="navigator.clipboard.writeText('{{ route('orders.share', $order->id) }}'); alert('Bill link copied!');">
                                          <i class="fas fa-link"></i>
                                      </button>

                                      <!-- View -->
                                      <button class="btn btn-sm btn-outline-info me-1"
                                          wire:click.prevent="viewOrder({{ $order->id }})" data-bs-toggle="modal"
                                          data-bs-target="#orderModal">
                                          <i class="fas fa-eye"></i>
                                      </button>

                                      <!-- Print -->
                                      <a class="btn btn-sm btn-outline-primary me-1"
                                          href="{{ route('orders.print', $order->id) }}" target="_blank">
                                          <i class="fas fa-print"></i>
                                      </a>

                                      <!-- Delete -->
                                      <button class="btn btn-sm btn-outline-danger"
                                          wire:click.prevent="confirmDeleteOrder({{ $order->id }})">
                                          <i class="fas fa-trash"></i>
                                      </button>
                                  </td>

                              </tr>
                          @empty
                              <tr>
                                  <td colspan="7" class="text-center text-muted py-4">
                                      <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                      <strong>No orders found.</strong>
                                  </td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
                  <div class="mt-3 px-4">
                      {{ $orders->links('livewire::bootstrap') }}
                  </div>
              </div>
          </div>

      </div>


      <!-- Modal -->
      <div wire:ignore.self class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Order Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                      @if ($selectedOrder)
                          <div class="row mb-3">
                              <div class="col-md-6">
                                  <h6>Customer Info</h6>
                                  <p><strong>Name:</strong> {{ $selectedOrder->customer->name ?? 'N/A' }}</p>
                                  <p><strong>Phone:</strong> {{ $selectedOrder->customer->phone ?? 'N/A' }}</p>
                                  <p><strong>Address:</strong> {{ $selectedOrder->customer->address ?? 'N/A' }}</p>
                                  <p><strong>Vehicle Number:</strong>
                                      {{ $selectedOrder->customer->vehicle_number ?? 'N/A' }}</p>
                                  <p><strong>Staff Name :</strong> {{ $selectedOrder->staff->name ?? 'N/A' }}</p>
                              </div>
                              <div class="col-md-6">
                                  <h6>Order Summary</h6>
                                  <p><strong>Subtotal:</strong> ₹{{ number_format($selectedOrder->subtotal, 2) }}</p>
                                  <p><strong>Discount:</strong> ₹{{ number_format($selectedOrder->discount, 2) }}</p>
                                  <p><strong>Total:</strong> ₹{{ number_format($selectedOrder->total, 2) }}</p>
                                  <p><strong>Remark:</strong> {{ $selectedOrder->remark ?? '-' }}</p>
                                  <p><strong>Date:</strong> {{ $selectedOrder->created_at->format('d M Y, h:i A') }}
                                  </p>
                              </div>
                          </div>

                          <h6>Items</h6>
                          <ul class="list-group">
                              @foreach ($selectedOrder->items as $item)
                                  <li class="list-group-item">
                                      <strong>{{ $item->item_name }}</strong> -
                                      ₹{{ $item->price }} × {{ $item->quantity }} = ₹{{ $item->total_price }}

                                      @if ($item->addons && $item->addons->count())
                                          <div><small>Addons:</small>
                                              <ul class="mb-0 ps-3">
                                                  @foreach ($item->addons as $addon)
                                                      <li>{{ $addon->name }} (₹{{ $addon->price }})</li>
                                                  @endforeach
                                              </ul>
                                          </div>
                                      @endif

                                      @if ($item->remark)
                                          <div class="text-muted"><small>Note: {{ $item->remark }}</small></div>
                                      @endif
                                  </li>
                              @endforeach
                          </ul>
                      @else
                          <p class="text-muted">Loading...</p>
                      @endif
                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>

      <!-- Delete Confirmation Modal -->
      @if($showDeleteModal)
      <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.6);">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content" style="border: 2px solid #800020; border-radius: 15px; box-shadow: 0 20px 40px rgba(128, 0, 32, 0.3);">
                  <div class="modal-header" style="background: #800020; color: white; border-radius: 13px 13px 0 0; text-align: center;">
                      <h5 class="modal-title" style="color: white; text-align: center; width: 100%;">
                          <i class="fas fa-exclamation-triangle me-2" style="color: white;"></i>
                          Confirm Order Deletion
                      </h5>
                  </div>
                  <div class="modal-body" style="padding: 25px;">
                      <div class="alert" style="background: rgba(128, 0, 32, 0.1); border: 1px solid rgba(128, 0, 32, 0.3); color: #800020; border-radius: 10px;">
                          <i class="fas fa-warning me-2" style="color: #800020;"></i>
                          <strong>Warning:</strong> This action cannot be undone. The order and all its items will be permanently deleted.
                      </div>
                      
                      <p class="mb-3" style="color: #333; font-weight: 500;">To confirm deletion, please enter the admin password:</p>
                      
                      <div class="form-group">
                          <label for="deletePassword" class="form-label" style="color: #800020; font-weight: 600;">Admin Password</label>
                          <input type="password" 
                                 class="form-control @error('deletePassword') is-invalid @enderror" 
                                 id="deletePassword"
                                 wire:model="deletePassword" 
                                 placeholder="Enter admin password"
                                 autofocus
                                 style="border: 2px solid rgba(128, 0, 32, 0.2); border-radius: 8px; padding: 12px;">
                          @if($deletePasswordError)
                              <div class="invalid-feedback d-block" style="color: #800020; font-weight: 500;">
                                  {{ $deletePasswordError }}
                              </div>
                          @endif
                      </div>
                  </div>
                  <div class="modal-footer" style="border-top: 1px solid rgba(128, 0, 32, 0.2); padding: 20px 25px;">
                      <button type="button" class="btn btn-secondary" wire:click="cancelDelete" style="border-radius: 8px; padding: 10px 20px; font-weight: 500;">
                          <i class="fas fa-times me-1"></i> Cancel
                      </button>
                      <button type="button" class="btn" wire:click="deleteOrder" style="background: #800020; border: 2px solid #800020; color: white; border-radius: 8px; padding: 10px 20px; font-weight: 600;">
                          <i class="fas fa-trash me-1"></i> Delete Order
                      </button>
                  </div>
              </div>
          </div>
      </div>
      @endif

  </div>
