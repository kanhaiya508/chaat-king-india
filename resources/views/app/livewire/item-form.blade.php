  <div class="container-xxl flex-grow-1 container-p-y">


      <div class="row g-4">
          <div class="col-md-12">
              @if ($step === 1)
                  <div class="card">
                      <div class="card-header ">
                          <h5 class=" text-primary">Item Information</h5>
                      </div>

                      <div class="card-body">
                          <form wire:submit.prevent="saveItem">
                              <div class="row">

                                  <div class="col-md-4 mb-3">
                                      <label>Name</label>
                                      <input wire:model.defer="name" type="text"
                                          class="form-control @error('name') is-invalid @enderror">
                                      @error('name')
                                          <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                  </div>

                                  <div class="col-md-4 mb-3">
                                      <label>Category</label>
                                      <select wire:model.defer="category_id"
                                          class="form-select @error('category_id') is-invalid @enderror">
                                          <option value="">-- Select Category --</option>
                                          @foreach ($categories as $cat)
                                              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                          @endforeach
                                      </select>
                                      @error('category_id')
                                          <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                  </div>


                              </div>

                              <div class="form-check mb-3">
                                  <input wire:model="is_available" type="checkbox" class="form-check-input"
                                      id="isAvailable">
                                  <label for="isAvailable" class="form-check-label">Available</label>
                              </div>
                              <button class="btn btn-primary">Next</button>
                          </form>
                      </div>
                  </div>
              @elseif ($step === 2)
                  <div class="custom-card">
                      <div class="mb-3 d-flex justify-content-between">
                          <h5 class=" text-primary">Item Variants</h5>
                          <button wire:click.prevent="addVariant" class="btn btn-outline-secondary btn-sm ">+ Add
                              Variant</button>
                      </div>

                      @foreach ($variants as $i => $variant)
                          <div class="row g-2 mb-2">
                              <div class="col">
                                  <input wire:model="variants.{{ $i }}.label" class="form-control"
                                      placeholder="Name">
                                  @error("variants.$i.label")
                                      <span class="text-danger small">{{ $message }}</span>
                                  @enderror
                              </div>

                              <div class="col">
                                  <input wire:model="variants.{{ $i }}.price" class="form-control"
                                      placeholder="Price">
                                  @error("variants.$i.price")
                                      <span class="text-danger small">{{ $message }}</span>
                                  @enderror
                              </div>

                              <div class="col-auto">
                                  <button type="button" class="btn btn-danger btn-sm"
                                      wire:click="removeVariant({{ $i }})">
                                      Remove
                                  </button>
                              </div>

                          </div>
                      @endforeach

                      <div class="mt-3 d-flex  justify-content-between">
                          <button wire:click="$set('step', 1)" class="btn btn-secondary">Back</button>
                          <button wire:click="saveVariants" class="btn btn-primary">Next</button>
                      </div>
                  </div>
              @elseif ($step === 3)
                  <div class="custom-card">
                      <div class="mb-3  d-flex justify-content-between">
                          <h5 class="text-primary">Item Addons</h5>
                          <button wire:click.prevent="addAddons" class="btn btn-outline-secondary btn-sm ">+ Add
                              Addon</button>
                      </div>
                      @foreach ($addons as $i => $addon)
                          <div class="row g-2 mb-2">
                              <div class="col">
                                  <input wire:model="addons.{{ $i }}.name" class="form-control"
                                      placeholder="Name">
                                  @error("addons.$i.name")
                                      <small class="text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                              <div class="col">
                                  <input wire:model="addons.{{ $i }}.price" class="form-control"
                                      placeholder="Price">
                                  @error("addons.$i.price")
                                      <small class="text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                              <div class="col-auto">
                                  <button type="button" class="btn btn-danger btn-sm"
                                      wire:click="removeAddon({{ $i }})">
                                      Remove
                                  </button>
                              </div>
                          </div>
                      @endforeach


                      <div class="mt-3 d-flex justify-content-between">
                          <button wire:click="$set('step', 2)" class="btn btn-secondary">Back</button>
                          <button wire:click="saveAddons" class="btn btn-success">Finish</button>
                      </div>
                  </div>
              @endif
          </div>

          <div class="col-md-12">
              <div class="card">
                  <div class="card-header ">
                      <h5 class=" mb-0  text-primary">Item List</h5>
                  </div>
                  <div class="card-body p-0">
                      <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Name</th>
                                      <th>Category</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($items as $index => $item)
                                      <tr>
                                          <td>{{ $index + 1 }}</td>
                                          <td>{{ $item->name }}</td>
                                          <td>{{ $item->category->name }}</td>
                                          <td>
                                              <div class="d-flex">
                                                  <!-- Button -->
                                                  <button wire:click="viewItemDetail({{ $item->id }})"
                                                      class="btn btn-sm btn-info me-1">
                                                      View
                                                  </button>
                                                  <button wire:click="editItem({{ $item->id }})"
                                                      class="btn btn-sm btn-warning me-1">Edit</button>
                                                  <button wire:click="deleteItem({{ $item->id }})"
                                                      onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                      class="btn btn-sm btn-danger">Delete</button>
                                              </div>

                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                          <div class="mt-3 px-3">
                              {{ $items->links('livewire::bootstrap') }}
                          </div>
                      </div>
                  </div>
              </div>


          </div>

          <!-- Item Detail Modal -->
          <div class="modal fade" id="itemDetailModal" tabindex="-1" aria-labelledby="itemDetailModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      @if ($viewItem)
                          <div class="modal-header">
                              <h5 class="modal-title" id="itemDetailModalLabel">{{ $viewItem->name }} Details</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                              <p><strong>Category:</strong> {{ $viewItem->category->name }}</p>
                              <p><strong>Available:</strong> {{ $viewItem->is_available ? 'Yes' : 'No' }}</p>

                              <hr>
                              <h6>Variants:</h6>
                              <ul>
                                  @foreach ($viewItem->variants as $variant)
                                      <li>{{ $variant->label }} - ₹{{ $variant->price }}</li>
                                  @endforeach
                              </ul>

                              <h6 class="mt-3">Addons:</h6>
                              <ul>
                                  @foreach ($viewItem->addons as $addon)
                                      <li>{{ $addon->name }} - ₹{{ $addon->price }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                  </div>
              </div>
          </div>
          @push('scripts')
              <script>
                  let itemModal;

                  Livewire.on('open-item-detail', () => {
                      const modalEl = document.getElementById('itemDetailModal');
                      itemModal = new bootstrap.Modal(modalEl);
                      itemModal.show();
                  });

                  Livewire.on('close-item-detail', () => {
                      if (itemModal) {
                          itemModal.hide();
                      }
                  });
              </script>
          @endpush

      </div>
