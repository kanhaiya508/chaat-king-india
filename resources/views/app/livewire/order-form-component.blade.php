  <div class="container-xxl flex-grow-1 container-p-y">

      @if ($showForm)
          <div class="order-summary card shadow-sm rounded-3 p-3">
              {{-- Top Action Bar --}}
              <div class="d-flex flex-wrap justify-content-between align-items-center my-4 gap-2">

                  <!-- Left Side Buttons -->
                  <div class="d-flex gap-2">
                      <x-loader-button action="Takeaway" label="Takeaway" class="btn btn-primary" />
                      <x-loader-button action="Delivery" label="Delivery" class="btn btn-danger" />
                      <x-loader-button action="RunningOrder" :label="$isRunningOrder ? 'Back to Tables' : 'Orders'" class="btn btn-light" />
                  </div>

                  <!-- Right Side Legends -->
                  <div class="d-flex gap-2 align-items-center flex-wrap">
                      <span class="legend-circle" style="background-color: #e0e0e0;"></span> <small>Blank Table</small>
                      <span class="legend-circle" style="background-color: #4ae42b;"></span> <small>Running
                          Table</small>
                      <span class="legend-circle" style="background-color: #de3918;"></span> <small>Printed
                          Table</small>
                  </div>

              </div>

              @if ($isRunningOrder)
                  <!-- Filter and Search Section -->
                  <div class="row mt-3 mb-3">
                      <div class="col-12">
                          <div class="card">
                              <div class="card-body">
                                  <div class="row g-3">
                                      <div class="col-md-4">
                                          <label class="form-label">Search Orders</label>
                                          <input type="text" class="form-control" wire:model.live="search"
                                              placeholder="Search by ID, Name, or Phone">
                                      </div>
                                      <div class="col-md-4">
                                          <label class="form-label">Filter by Type</label>
                                          <select class="form-select" wire:model.live="orderType">
                                              <option value="">All Types</option>
                                              <option value="dine-in">Dine-in</option>
                                              <option value="takeaway">Takeaway</option>
                                              <option value="delivery">Delivery</option>
                                          </select>
                                      </div>
                                      <div class="col-md-4 d-flex align-items-end">
                                          <button class="btn btn-outline-secondary" wire:click="loadAllOrders">
                                              <i class="fas fa-refresh me-1"></i> Refresh
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Orders Grid -->
                  <div class="row">
                      @forelse($allOrders as $order)
                          <div class="col-lg-3 col-md-4 col-sm-6 mb-4" wire:click="viewOrder({{ $order->id }})"
                              style="cursor:pointer;">
                              <div class="card border shadow-sm rounded-3 h-100">
                                  <div class="card-body p-3">
                                      <div class="d-flex justify-content-between align-items-center mb-3">
                                          <h4 class="card-title mb-0 text-primary">#{{ $order->id }}</h4>
                                          <div class="d-flex flex-column gap-1">
                                              <span
                                                  class="badge bg-primary text-white small">{{ ucfirst($order->type) }}</span>
                                              <span
                                                  class="badge bg-warning text-dark small">{{ ucfirst($order->status) }}</span>
                                          </div>
                                      </div>

                                      <div class="mb-2">
                                          @if ($order->customer && $order->customer->name)
                                              <strong class="text-muted">Customer:</strong>
                                              <span class="text-primary">{{ $order->customer->name }}</span>
                                          @endif
                                      </div>

                                      <div class="mb-2">
                                          <strong class="text-muted">Type:</strong>
                                          @if ($order->table_id)
                                              <span class="text-primary">Table #{{ $order->table_id }}</span>
                                          @else
                                              <span class="text-success">{{ ucfirst($order->type) }}</span>
                                          @endif
                                      </div>

                                      <div class="mb-2">
                                          <strong class="text-muted">Total:</strong>
                                          <span
                                              class="text-danger fw-bold fs-5">₹{{ number_format($order->total, 2) }}</span>
                                      </div>

                                      <div class="text-muted small">
                                          <i
                                              class="fas fa-clock me-1"></i>{{ $order->created_at->format('d M, h:i A') }}
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @empty
                          <div class="col-12">
                              <div class="text-center py-5">
                                  <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                                  <h4 class="text-muted">No orders found</h4>
                                  <p class="text-muted">Try adjusting your search or filter criteria</p>
                              </div>
                          </div>
                      @endforelse
                  </div>
              @else
                  <div class="overflow-auto">
                      @foreach ($tablecategories as $category)
                          <!-- Category Heading -->
                          <h5 class="mb-3">{{ $category->name }}</h5>
                          <!-- Tables Grid -->
                          <div class="table-grid">
                              @forelse ($category->tables as $table)
                                  <div class="table-box-wrapper position-relative">
                                      <div
                                          class="table-box {{ $this->getTableStatusClass($table->latestOrder?->status) }} position-relative">
                                          <!-- Main table content - clickable area -->
                                          <div wire:click="openOrderForm({{ $table->id }})"
                                              wire:loading.attr="disabled"
                                              wire:target="openOrderForm({{ $table->id }})"
                                              style="cursor: pointer;">
                                              <h5>{{ $table->name }}</h5>
                                              @if ($table->latestOrder && $table->latestOrder->status !== null)
                                                  <div class="order-info">
                                                      <small><strong>Order #{{ $table->latestOrder->id }}</strong></small><br>
                                                      <small>{{ ucfirst($table->latestOrder->status) }}</small><br>
                                                      @php
                                                          $minutesRunning = $table->latestOrder->created_at->diffINMinutes(now());
                                                      @endphp
                                                      <small class="time-running">
                                                          <i class="fas fa-clock me-1"></i>{{ $minutesRunning }} Min
                                                      </small>
                                                  </div>
                                              @endif
                                          </div>

                                          <!-- Settlement Button - only show if table has active order -->
                                          @if ($table->latestOrder && $table->latestOrder->status !== null)
                                              <div class="position-absolute top-0 end-0 p-2">
                                                  <button class="btn btn-sm btn-success shadow-sm"
                                                      wire:click="openSettlementForTable({{ $table->latestOrder->id }})"
                                                      wire:loading.attr="disabled"
                                                      wire:target="openSettlementForTable({{ $table->latestOrder->id }})"
                                                      title="Quick Settlement"
                                                      style="border-radius: 50%; width: 35px; height: 35px; padding: 0;">
                                                      <i class="fas fa-receipt" style="font-size: 12px;"></i>
                                                  </button>
                                              </div>
                                          @endif

                                          <div wire:loading wire:target="openOrderForm({{ $table->id }})"
                                              class="position-absolute top-50 start-50 translate-middle">
                                              <i class="fas fa-spinner fa-spin text-white"></i>
                                          </div>
                                      </div>
                                  </div>
                              @empty
                                  <p class="text-muted">No tables in this category.</p>
                              @endforelse
                          </div>

                          <hr class="my-4">
                      @endforeach
                  </div>
              @endif
          </div>
      @else
          <div class="row g-2">
              <!-- Item Selection Area -->
              <div class="col-md-7">
                  <div class=" card shadow-sm rounded-3 p-0">
                      <div class="row">

                          <!-- Category Tabs (Vertical) -->
                          <div class="col-md-3 ">
                              <div style="min-height:540px; max-height:540px; overflow-y:auto; background:#d1d5db;"
                                  class="nav flex-column nav-pills custom-category-tabs shadow-sm rounded p-2"
                                  id="categoryTabs" role="tablist" aria-orientation="vertical">

                                  @foreach ($categories as $index => $category)
                                      <button
                                          class="nav-link text-start mb-1 {{ $activeCategoryTab == $index ? 'active' : '' }}"
                                          id="tab-{{ $index }}-tab"
                                          wire:click="selectCategoryTab({{ $index }})" type="button"
                                          role="tab" aria-controls="tab-{{ $index }}"
                                          aria-selected="{{ $activeCategoryTab == $index ? 'true' : 'false' }}">
                                          {{ $category->name }}
                                      </button>
                                  @endforeach
                              </div>
                          </div>


                          <!-- Items Content -->
                          <div class="col-md-9">
                              <div class="tab-content" id="categoryTabsContent">
                                  @foreach ($categories as $index => $category)
                                      <div class="tab-pane fade {{ $activeCategoryTab == $index ? 'show active' : '' }}"
                                          id="tab-{{ $index }}" role="tabpanel"
                                          aria-labelledby="tab-{{ $index }}-tab">

                                          <div class="row g-3">
                                              @forelse ($category->items as $item)
                                                  <div class="col-md-4 col-sm-6">
                                                      <div class="card border shadow-sm rounded-3"
                                                          wire:click="openModal({{ $item->id }})"
                                                          style="cursor: pointer;">

                                                          <div class="card-body p-3 text-center">
                                                              <p class="fw-bold mb-0">{{ $item->name }}</p>
                                                          </div>
                                                      </div>
                                                  </div>
                                              @empty
                                                  <div class="col-12">
                                                      <div class="alert alert-light text-center m-0">
                                                          No items found in this category.
                                                      </div>
                                                  </div>
                                              @endforelse
                                          </div>
                                      </div>
                                  @endforeach
                              </div>
                          </div>
                      </div>

                  </div>

              </div>
              <!-- Cart Section -->
              <div class="col-md-5">
                  <div class="order-summary card shadow-sm rounded-3  px-3 ">
                      <!-- Nav Tabs -->
                      <div class="overflow-auto">
                          <ul class="nav nav-tabs nav-fill mb-3" role="tablist">
                              <li class="nav-item">
                                  <button class="nav-link {{ $activeTab === 'items-tab' ? 'active' : '' }}"
                                      wire:click="$set('activeTab','items-tab')" type="button" role="tab">
                                      <i class="ti tabler-home me-1"></i> Order Items
                                      <span class="badge bg-danger ms-1">{{ count($cart) }}</span>
                                  </button>

                              </li>
                              <li class="nav-item">
                                  <button class="nav-link {{ $activeTab === 'customer-tab' ? 'active' : '' }}"
                                      wire:click="$set('activeTab','customer-tab')" type="button" role="tab">
                                      <i class="ti tabler-user me-1"></i> Customer
                                  </button>
                              </li>

                              @if ($isDelivery)
                                  <li class="nav-item">
                                      <button class="nav-link {{ $activeTab === 'delivery-tab' ? 'active' : '' }}"
                                          wire:click="$set('activeTab','delivery-tab')" type="button"
                                          role="tab">
                                          <i class="ti tabler-truck-delivery me-1"></i> Delivery Partner
                                      </button>
                                  </li>
                              @endif
                              <li class="nav-item">
                                  <button class="nav-link {{ $activeTab === 'remark-tab' ? 'active' : '' }}"
                                      wire:click="$set('activeTab','remark-tab')" type="button" role="tab">
                                      <i class="ti tabler-message-dots me-1"></i> Remark
                                  </button>
                              </li>



                          </ul>
                      </div>
                      <div class="tab-content  pt-0  ">
                          <!-- Items Tab -->
                          <div class="tab-pane fade {{ $activeTab === 'items-tab' ? 'show active' : '' }}"
                              id="items-tab" role="tabpanel">
                              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                  <div class="d-flex align-items-center gap-2">
                                      <h6 class="mb-0 text-primary">Order Items</h6>
                                      @if (!empty($tabelcat) && !empty($tabelnam))
                                          <span class="text-primary small">| {{ $tabelcat }} -
                                              {{ $tabelnam }}</span>
                                      @else
                                          <span class="text-primary small">| {{ $type }}</span>
                                      @endif
                                  </div>
                                  <div class="">
                                      <select class="form-control form-control-sm  mb-2" wire:model="staff_id">
                                          <option value="">-- Select Staff --</option>
                                          @foreach ($staffList as $staff)
                                              <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                          @endforeach
                                      </select>
                                  </div>

                                  <button class="btn btn-sm btn-outline-danger" wire:click="$set('cart', [])"
                                      wire:loading.attr="disabled" wire:target="$set('cart', [])">
                                      <span wire:loading.remove wire:target="$set('cart', [])">Clear All</span>
                                      <span wire:loading wire:target="$set('cart', [])">
                                          <i class="fas fa-spinner fa-spin"></i> Clearing...
                                      </span>
                                  </button>


                              </div>

                              <div style="min-height: 400px; max-height:400px; overflow-y: auto;">
                                  <table class="table ">
                                      <thead>
                                          <tr>
                                              <th>Item</th>
                                              <th>Qty</th>
                                              <th>Price</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @php
                                              $subtotal = 0;
                                              // Sort cart to maintain group order and item order within groups
                                              $sortedCart = collect($cart)->sortBy([
                                                  ['kot_group_id', 'asc'],
                                                  ['kot_printed', 'asc'], // Unprinted first
                                                  ['order_item_id', 'desc'], // Latest first within group
                                              ]);
                                              // Group by kot_group_id, but keep printed and unprinted items separate
                                              $groupedCart = $sortedCart->groupBy(function ($item) {
                                                  if ($item['kot_group_id']) {
                                                      return $item['kot_group_id'] .
                                                          '_' .
                                                          ($item['kot_printed'] ? 'printed' : 'pending');
                                                  }
                                                  return 'new_items';
                                              });
                                          @endphp
                                          @foreach ($groupedCart as $kotGroupKey => $groupItems)
                                              @if ($kotGroupKey !== 'new_items')
                                                  @php
                                                      // Extract kot_group_id and status from the key
                                                      $parts = explode('_', $kotGroupKey);
                                                      $kotGroupId = $parts[0];
                                                      $status = end($parts);
                                                      $isPrinted = $status === 'printed';
                                                  @endphp
                                                  <tr class="{{ $isPrinted ? 'table-success' : 'table-info' }}">
                                                      <td colspan="4" class="fw-bold">
                                                          <div
                                                              class="d-flex justify-content-between align-items-center">
                                                              <div>
                                                                  <i class="fas fa-print me-2"></i>
                                                                  KOT Group: {{ $kotGroupId }}
                                                                  <small class="text-muted ms-2">
                                                                      ({{ $groupItems->count() }} items)
                                                                  </small>
                                                              </div>
                                                              {{-- @if (!$isPrinted)
                                                              <button type="button" class="btn btn-sm btn-outline-primary" 
                                                                  onclick="printKOTGroup('{{ $kotGroupId }}')">
                                                                  <i class="fas fa-print me-1"></i> Print Group
                                                              </button>
                                                              @else
                                                              <span class="text-success small">
                                                                  <i class="fas fa-check me-1"></i>Already Printed
                                                              </span>
                                                              @endif --}}
                                                          </div>
                                                      </td>
                                                  </tr>
                                              @else
                                                  <tr class="table-warning">
                                                      <td colspan="4" class="fw-bold">
                                                          <i class="fas fa-shopping-cart me-2"></i>
                                                          New Items (Not Saved Yet)
                                                          <span class="badge bg-info ms-2">Cart</span>
                                                          <small class="text-muted ms-2">
                                                              ({{ $groupItems->count() }} items)
                                                          </small>
                                                      </td>
                                                  </tr>
                                              @endif
                                              @foreach ($groupItems as $index => $item)
                                                  @php
                                                      $variant = $item['item']->variants->firstWhere(
                                                          'id',
                                                          $item['variant_id'],
                                                      );
                                                      $variantPrice = $variant?->price ?? 0;
                                                      $addonTotal = collect($item['addon_ids'])->sum(
                                                          fn($id) => $item['item']->addons->firstWhere('id', $id)
                                                              ?->price ?? 0,
                                                      );
                                                      $totalItemPrice =
                                                          ($variantPrice + $addonTotal) * $item['quantity'];
                                                      $subtotal += $totalItemPrice;
                                                  @endphp
                                                  <tr>
                                                      <td>
                                                          <span>
                                                              {{ $item['item']->name }}
                                                              @if ($variant)
                                                                  <br><small
                                                                      class="text-muted">({{ $variant->label }})</small>
                                                              @endif
                                                              @if (!empty($item['addon_ids']))
                                                                  <br><small class="text-muted">
                                                                      Addons: @foreach ($item['addon_ids'] as $addonId)
                                                                          {{ $item['item']->addons->firstWhere('id', $addonId)?->name }},
                                                                      @endforeach
                                                                  </small>
                                                              @endif
                                                              @if (!empty($item['remark']))
                                                                  <div class="text-muted small">
                                                                      <i class="fas fa-quote-left "
                                                                          title="Remark"></i>
                                                                      {{ $item['remark'] }} <i
                                                                          class="fas fa-quote-right "
                                                                          title="Remark"></i>
                                                                  </div>
                                                              @endif
                                                          </span>
                                                          <button type="button"
                                                              class="btn btn-sm btn-outline-primary ms-2"
                                                              data-bs-toggle="modal"
                                                              data-bs-target="#remarkModal{{ $index }}">
                                                              <i class="fas fa-comment"></i>
                                                          </button>
                                                      </td>
                                                      <td>
                                                          <div class="input-group input-group-sm">
                                                              <button class="btn btn-outline-secondary"
                                                                  wire:click="decreaseQty({{ $index }})"
                                                                  wire:loading.attr="disabled"
                                                                  wire:target="decreaseQty({{ $index }})">−</button>
                                                              <input type="text" class="form-control text-center"
                                                                  wire:model.lazy="cart.{{ $index }}.quantity" />
                                                              <button class="btn btn-outline-secondary"
                                                                  wire:click="increaseQty({{ $index }})"
                                                                  wire:loading.attr="disabled"
                                                                  wire:target="increaseQty({{ $index }})">+</button>
                                                          </div>
                                                      </td>
                                                      <td>
                                                          <div
                                                              class="d-flex align-items-center justify-content-between">
                                                              <span>₹{{ number_format($totalItemPrice, 2) }}</span>
                                                              <button type="button"
                                                                  class="btn btn-sm btn-outline-danger ms-2"
                                                                  wire:click="removeItem({{ $index }})"
                                                                  wire:loading.attr="disabled"
                                                                  wire:target="removeItem({{ $index }})">
                                                                  <span wire:loading.remove
                                                                      wire:target="removeItem({{ $index }})">
                                                                      <i class="fas fa-trash"></i>
                                                                  </span>
                                                                  <span wire:loading
                                                                      wire:target="removeItem({{ $index }})">
                                                                      <i class="fas fa-spinner fa-spin"></i>
                                                                  </span>
                                                              </button>
                                                          </div>
                                                      </td>
                                                  </tr>
                                              @endforeach
                                          @endforeach
                                          @if (empty($cart))
                                              <tr>
                                                  <td colspan="3" class="text-center text-muted">No items
                                                      selected.
                                                  </td>
                                              </tr>
                                          @endif
                                      </tbody>
                                  </table>
                              </div>
                          </div>

                          <!-- Customer Tab -->
                          <div class="tab-pane  {{ $activeTab === 'customer-tab' ? 'show active' : '' }}  fade"
                              id="customer-tab" role="tabpanel">

                              <label class="form-label">Customer Name</label>
                              <input type="text"
                                  class="form-control form-control mb-2 @error('customerName') is-invalid @enderror"
                                  placeholder="Customer Name" wire:model.lazy="customerName">
                              @error('customerName')
                                  <div class="text-danger small">{{ $message }}</div>
                              @enderror



                              <label class="form-label">Phone Number</label>
                              <input type="text"
                                  class="form-control form-control mb-2 @error('phone') is-invalid @enderror"
                                  placeholder="Phone Number" wire:model.lazy="phone">
                              @error('phone')
                                  <div class="text-danger small">{{ $message }}</div>
                              @enderror


                              <label class="form-label">Vehicle Number</label>
                              <input type="text"
                                  class="form-control form-control mb-2 @error('vehicle_number') is-invalid @enderror"
                                  placeholder="Vehicle Number" wire:model.lazy="vehicle_number">
                              @error('vehicle_number')
                                  <div class="text-danger small">{{ $message }}</div>
                              @enderror


                              <label class="form-label">Address</label>
                              <textarea class="form-control form-control mb-2" rows="3" placeholder="Address" wire:model.lazy="address"></textarea>
                          </div>

                          {{-- Delivery Partner  --}}
                          <div class="tab-pane  {{ $activeTab === 'delivery-tab' ? 'show active' : '' }}  fade"
                              id="delivery-tab" role="tabpanel">
                              {{-- Delivery Partner Name --}}
                              <div class="mb-3">
                                  <label class="form-label">Delivery Partner Name</label>
                                  <input type="text" class="form-control" placeholder="Enter partner name"
                                      wire:model.lazy="deliveryPartnerName">
                              </div>

                              {{-- Delivery Partner Phone --}}
                              <div class="mb-3">
                                  <label class="form-label">Delivery Partner Phone</label>
                                  <input type="text" class="form-control" placeholder="Enter phone number"
                                      wire:model.lazy="deliveryPartnerPhone">
                              </div>

                              {{-- Delivery Location --}}
                              <div class="mb-3">
                                  <label class="form-label">Delivery Location</label>
                                  <input type="text" class="form-control" placeholder="Enter delivery location"
                                      wire:model.lazy="deliveryLocation">
                              </div>

                              {{-- Delivery Distance (km) --}}
                              <div class="mb-3">
                                  <label class="form-label">Distance (km)</label>
                                  <input type="number" class="form-control" placeholder="Enter distance in km"
                                      wire:model.lazy="deliveryDistance">
                              </div>
                          </div>


                          <!-- Remark Tab -->
                          <div class="tab-pane  {{ $activeTab === 'remark-tab' ? 'show active' : '' }} fade"
                              id="remark-tab" role="tabpanel">
                              <textarea class="form-control form-control mb-2" rows="3" placeholder="Order Remark (optional)"
                                  wire:model.lazy="orderRemark"></textarea>
                          </div>
                      </div>



                  </div>
              </div>

          </div>

          <!-- Modal -->
          @if ($showModal && $selectedItem)
              <div class="modal fade show d-block" tabindex="-1" role="dialog"
                  style="background-color: rgba(0,0,0,0.5); z-index:1050;">
                  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content shadow rounded-4">
                          <div class="modal-header">
                              <h5 class="modal-title">{{ $selectedItem->name }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                  wire:click="closeModal"></button>
                          </div>

                          <div class="modal-body p-4">
                              {{-- Variants --}}
                              @if ($selectedItem->variants->count())
                                  <div class="mb-4">
                                      <h6 class="fw-bold border-bottom pb-2">Choose Variant</h6>
                                      <div class="row">
                                          @foreach ($selectedItem->variants as $variant)
                                              <div class="col-md-4 mb-3">
                                                  <input type="radio" id="variant{{ $variant->id }}"
                                                      class="variant-radio" wire:model="selectedItemVariants"
                                                      name="variant" value="{{ $variant->id }}">
                                                  <label for="variant{{ $variant->id }}" class="variant-box">
                                                      <strong>{{ $variant->label }}</strong><br>
                                                      <small class="text-muted">₹{{ $variant->price }}</small>
                                                  </label>
                                              </div>
                                          @endforeach
                                      </div>
                                      @error('selectedItemVariants')
                                          <div class="text-danger small mt-1">{{ $message }}</div>
                                      @enderror
                                  </div>
                              @endif

                              {{-- Addons --}}
                              @if ($selectedItem->addons->count())
                                  <div class="mb-4">
                                      <h6 class="fw-bold border-bottom pb-2">Add Addons</h6>
                                      <div class="row">
                                          @foreach ($selectedItem->addons as $addon)
                                              <div class="col-md-4 mb-3">
                                                  <input type="checkbox" id="addon{{ $addon->id }}"
                                                      class="addon-checkbox" wire:model="selectedItemAddons"
                                                      value="{{ $addon->id }}">
                                                  <label for="addon{{ $addon->id }}" class="addons-box">
                                                      <strong>{{ $addon->name }}</strong><br>
                                                      <small class="text-muted">₹{{ $addon->price }}</small>
                                                  </label>
                                              </div>
                                          @endforeach
                                      </div>
                                  </div>
                              @endif


                          </div>

                          <div class="modal-footer">


                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                  wire:click="closeModal">Cancel</button>

                              <x-loader-button action="addSelectedItemToCart" label="Add to Cart"
                                  class="btn btn-primary" />
                          </div>

                      </div>
                  </div>
              </div>
          @endif


          @foreach ($cart as $index => $item)
              <div wire:ignore.self class="modal fade" id="remarkModal{{ $index }}" tabindex="-1"
                  aria-labelledby="remarkModalLabel{{ $index }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="remarkModalLabel{{ $index }}">
                                  Add Remark for "{{ $item['item']->name }}"
                              </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                  aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <textarea wire:model.lazy="cart.{{ $index }}.remark" class="form-control" rows="3"
                                  placeholder="Write your remark here (e.g. No onion, extra spicy...)"></textarea>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary"
                                  data-bs-dismiss="modal">Cancel</button>
                              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                  Save Remark
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          @endforeach


          <!-- Sticky Order Summary Footer -->
          <div class="bg-white border-top shadow-lg fixed-bottom py-3">
              <div class="container-xxl px-4">
                  <div
                      class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 flex-wrap">

                      <!-- Totals Section -->
                      <div class="d-flex  align-items-center  gap-2">
                          <div class="mb-2 d-flex justify-content-between align-items-center">
                              <span class="fw-semibold fs-5">Subtotal:</span>
                              <span class="fs-5">₹{{ number_format($subtotal, 2) }}</span>
                          </div>

                          <div class="mb-2">
                              <div class="d-flex justify-content-between align-items-center">
                                  <span class="fw-semibold fs-5">Discount:</span>
                                  <div class="d-flex align-items-center gap-2">
                                      <div class="btn-group btn-group-sm" role="group">
                                          <input type="radio" class="btn-check" name="discountType" id="percent"
                                              wire:model="isPercent" wire:change="applyDiscount" value="1">
                                          <label class="btn btn-outline-primary" for="percent">%</label>

                                          <input type="radio" class="btn-check" name="discountType" id="flat"
                                              wire:model="isPercent" wire:change="applyDiscount" value="0">
                                          <label class="btn btn-outline-primary" for="flat">₹</label>
                                      </div>
                                      <input type="number" class="form-control form-control-sm" placeholder="0"
                                          wire:model="discountValue" min="0" wire:change="applyDiscount"
                                          style="width: 90px;">
                                  </div>
                              </div>
                          </div>

                          <div class="mb-2 d-flex justify-content-between align-items-center">
                              <span class="fw-bold fs-4">Total:</span>
                              <span class="fw-bold text-success fs-4">₹{{ number_format($finalTotal, 2) }}</span>
                          </div>
                      </div>

                      <!-- Action Buttons -->
                      <div class="d-flex flex-wrap justify-content-md-end justify-content-start gap-2">
                          <x-loader-button action="saveandSettlement" label="Save And Settlement"
                              class="btn btn-primary px-3" />
                          <x-loader-button action="saveOrder" label="Save" class="btn  btn-danger px-3" />
                          <x-loader-button action="saveOrderAndPrint" label="Save & Print"
                              class="btn  btn-info px-3" />
                          <x-loader-button action="saveOrderAsKOTAndPrint" label="Save & KOT Print"
                              class="btn  btn-success px-3" />
                          <x-loader-button action="saveOrderAsHold" label="Hold" class="btn  btn-dark px-3" />

                          @if ((($isEditing && $order_id) || (!empty($cart) && !$isEditing)) && $this->hasUnprintedItems())
                              <x-loader-button action="printUnprintedItems" label="Print Unprinted"
                                  class="btn btn-outline-success px-3" />
                          @endif
                          {{-- @if (!empty($cart) && !$isEditing)
                          <x-loader-button action="printKOTDirectly" label="Print KOT"
                              class="btn btn-outline-primary px-3" />
                          @endif --}}
                      </div>

                  </div>
              </div>
          </div>


      @endif

      <!-- Settlement Modal - Always accessible but conditionally shown -->
      <div class="modal fade {{ $saveandsettlement ? 'show d-block' : '' }}" tabindex="-1" role="dialog"
          style="{{ $saveandsettlement ? 'background-color: rgba(0,0,0,0.5); z-index:1050;' : 'display: none;' }}">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content shadow rounded-4">
                  <div class="modal-header">
                      <h5 class="modal-title">{{ $selectedItem->name ?? 'Settlement' }}</h5>
                      <button type="button" class="btn-close" wire:click="closeSettlement"
                          aria-label="Close"></button>
                  </div>

                  <div class="modal-body p-4">

                      <!-- Subtotal -->
                      <div class="mb-3 d-flex justify-content-between align-items-center border-bottom pb-2">
                          <span class="fw-semibold fs-5">Subtotal:</span>
                          <span class="fs-5">₹{{ number_format($subtotal, 2) }}</span>
                      </div>

                      <!-- Discount Section -->
                      <div class="mb-3 row align-items-center">
                          <label class="col-auto col-form-label fw-bold">Discount</label>

                          <div class="col-auto">
                              <div class="btn-group btn-group-sm" role="group">
                                  <input type="radio" class="btn-check" name="discountType" id="percent"
                                      wire:model="isPercent" wire:change="applyDiscount" value="1">
                                  <label class="btn btn-outline-primary" for="percent">%</label>

                                  <input type="radio" class="btn-check" name="discountType" id="flat"
                                      wire:model="isPercent" wire:change="applyDiscount" value="0">
                                  <label class="btn btn-outline-primary" for="flat">₹</label>
                              </div>
                          </div>

                          <div class="col">
                              <input type="number" class="form-control form-control-sm ms-auto" placeholder="0"
                                  wire:model="discountValue" min="0" wire:change="applyDiscount"
                                  style="max-width: 100px; float: right;">
                          </div>
                      </div>


                      <!-- Final Total -->
                      <div class="mb-4 d-flex justify-content-between align-items-center border-top pt-2">
                          <span class="fw-bold fs-4">Total:</span>
                          <span class="fw-bold text-success fs-4">₹{{ number_format($finalTotal, 2) }}</span>
                      </div>

                      <hr>

                      <div class="d-flex align-items-center justify-content-between mb-3">
                          <h5 class="mb-0">Payment</h5>
                      </div>


                      <!-- Payment Mode Section -->
                      <div class="mb-3">
                          <label class="form-label">Payment Mode</label>
                          <div class="d-flex gap-3">
                              <div class="form-check">
                                  <input class="form-check-input @error('payments.0.mode') is-invalid @enderror"
                                      type="radio" name="payment_mode_0" id="cash_0" value="Cash"
                                      wire:model="payments.0.mode">
                                  <label class="form-check-label" for="cash_0">
                                      Cash
                                  </label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input @error('payments.0.mode') is-invalid @enderror"
                                      type="radio" name="payment_mode_0" id="upi_0" value="UPI"
                                      wire:model="payments.0.mode">
                                  <label class="form-check-label" for="upi_0">
                                      UPI
                                  </label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input @error('payments.0.mode')	is-invalid @enderror"
                                      type="radio" name="payment_mode_0" id="card_0" value="Card"
                                      wire:model="payments.0.mode">
                                  <label class="form-check-label" for="card_0">
                                      Card
                                  </label>
                              </div>
                          </div>
                          @error('payments.0.mode')
                              <div class="invalid-feedback d-block">{{ $message }}</div>
                          @enderror
                      </div>

                      <!-- Payment Details Section -->
                      <div class="row g-2 align-items-center mb-2">
                          <div class="col-md-4">
                              <label class="form-label">Amount</label>
                              <input type="number"
                                  class="form-control form-control-sm @error('payments.0.amount') is-invalid @enderror"
                                  wire:model.live="payments.0.amount" placeholder="Amount" step="0.01">
                              @error('payments.0.amount')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                          <div class="col-md-4">
                              <label class="form-label">Tip Amount</label>
                              <input type="number" class="form-control form-control-sm" wire:model.live="tipAmount"
                                  placeholder="Tip Amount" step="0.01" min="0">
                          </div>
                          <div class="col-md-4">
                              <label class="form-label">Note</label>
                              <input type="text" class="form-control form-control-sm" wire:model="payments.0.note"
                                  placeholder="Note">
                          </div>
                      </div>

                      {{-- Remaining / Change --}}
                      <div class="d-flex justify-content-between mb-2">
                          <strong>Remaining Balance:</strong>
                          <strong class="{{ $this->shortfall > 0 ? 'text-danger' : 'text-success' }}">
                              ₹{{ number_format($this->shortfall, 2) }}
                          </strong>
                      </div>
                      @if ($this->changeDue > 0)
                          <div class="d-flex justify-content-between mb-2">
                              <strong>Change Due to Customer:</strong>
                              <strong class="text-info">₹{{ number_format($this->changeDue, 2) }}</strong>
                          </div>
                      @endif

                       {{-- Shortfall warning --}}
                       @if ($this->shortfall > 0)
                           <div class="alert alert-warning py-2">
                               <div class="d-flex align-items-center justify-content-between">
                                   <div>
                                       <div class="fw-semibold">Payment Shortfall:
                                           ₹{{ number_format($this->shortfall, 2) }}</div>
                                       <small class="text-muted">Customer still owes ₹{{ number_format($this->shortfall, 2) }}</small>
                                   </div>
                               </div>
                           </div>
                       @endif


                      <!-- Payment Summary -->
                      @if ($tipAmount > 0)
                          <div class="mb-2 d-flex justify-content-between">
                              <strong>Tip Amount:</strong>
                              <strong class="text-info">₹{{ number_format($tipAmount, 2) }}</strong>
                          </div>
                      @endif
                      <div class="mb-2 d-flex justify-content-between">
                          <strong>Total Paid:</strong>
                          <strong>₹{{ number_format($this->paymentTotal, 2) }}</strong>
                      </div>


                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" wire:click="closeSettlement">Cancel</button>
                      <div class="text-end">
                          <button class="btn btn-primary" wire:click="savePayments" wire:loading.attr="disabled"
                              wire:target="savePayments">
                              <span wire:loading.remove wire:target="savePayments">Confirm & Save</span>
                              <span wire:loading wire:target="savePayments">
                                  <i class="fas fa-spinner fa-spin"></i> Saving...
                              </span>
                          </button>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      @push('scripts')
          <script>
              // Print functionality
              document.addEventListener('livewire:init', () => {
                  // Print tracking to prevent duplicates
                  window.activePrints = new Set();

                  // Save & Print handler
                  Livewire.on('orderSavedForPrint', (orderId) => {
                      const key = `print_${orderId}`;
                      if (window.activePrints.has(key)) {
                          return;
                      }

                      window.activePrints.add(key);
                      const printUrl = `/orders/${orderId}/print`;

                      setTimeout(() => {
                          // Center the popup window
                          const width = 800;
                          const height = 600;
                          const left = (screen.width / 2) - (width / 2);
                          const top = (screen.height / 2) - (height / 2);

                          const printWindow = window.open(printUrl, '_blank',
                              `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
                          );

                          if (printWindow) {
                              // Override print settings
                              printWindow.addEventListener('load', () => {
                                  try {
                                      printWindow.document.body.style.setProperty('margin', '0',
                                          'important');
                                      printWindow.document.body.style.setProperty('padding', '0',
                                          'important');
                                  } catch (e) {
                                      // Silent fail for older browsers
                                  }
                              });
                              printWindow.addEventListener('afterprint', () => {
                                  printWindow.close();
                              });

                              const checkWindow = setInterval(() => {
                                  if (printWindow.closed) {
                                      clearInterval(checkWindow);
                                  }
                              }, 1000);

                              setTimeout(() => {
                                  if (!printWindow.closed) {
                                      printWindow.close();
                                      clearInterval(checkWindow);
                                  }
                              }, 10000);
                          }
                      }, 100);

                      setTimeout(() => {
                          window.activePrints.delete(key);
                      }, 2000);
                  });

                  // Save & KOT Print handler
                  Livewire.on('orderSavedForKOTPrint', (orderId) => {
                      const key = `kot_print_${orderId}`;
                      if (window.activePrints.has(key)) {
                          return;
                      }

                      window.activePrints.add(key);
                      const printUrl = `/orders/${orderId}/kot-print`;

                      setTimeout(() => {
                          // Center the popup window
                          const screenLeft = window.screenLeft || screen.left;
                          const screenTop = window.screenTop || screen.top;
                          const width = 600;
                          const height = 500;
                          const left = (screen.width / 2) - (width / 2);
                          const top = (screen.height / 2) - (height / 2);

                          const printWindow = window.open(printUrl, '_blank',
                              `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
                          );

                          if (printWindow) {
                              printWindow.addEventListener('afterprint', () => {
                                  printWindow.close();
                              });

                              const checkWindow = setInterval(() => {
                                  if (printWindow.closed) {
                                      clearInterval(checkWindow);
                                  }
                              }, 1000);

                              setTimeout(() => {
                                  if (!printWindow.closed) {
                                      printWindow.close();
                                      clearInterval(checkWindow);
                                  }
                              }, 10000);
                          }
                      }, 100);

                      setTimeout(() => {
                          window.activePrints.delete(key);
                      }, 2000);
                  });

                  // KOT HTML Print handler
                  Livewire.on('printKOTHTML', (html) => {
                      // Center the popup window
                      const width = 600;
                      const height = 500;
                      const left = (screen.width / 2) - (width / 2);
                      const top = (screen.height / 2) - (height / 2);

                      const printWindow = window.open('', '_blank',
                          `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
                      );

                      if (!printWindow) {
                          alert('Please allow popups to print KOT');
                          return;
                      }

                      printWindow.document.write(html);
                      printWindow.document.close();

                      printWindow.onload = function() {
                          printWindow.addEventListener('afterprint', () => {
                              printWindow.close();
                          });

                          setTimeout(() => {
                              printWindow.focus();
                              printWindow.print();

                              setTimeout(() => {
                                  if (!printWindow.closed) {
                                      printWindow.close();
                                  }
                              }, 500);
                          }, 500);
                      };
                  });
              });
          </script>
      @endpush


  </div>
