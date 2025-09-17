  <div class="container-xxl flex-grow-1 container-p-y">
    <div class=" mt-4">
        <h2>🧾 Order Details</h2>

        <div class="card p-3 mb-4 shadow-sm">
            <h5>Customer Details</h5>
            <p><strong>Name:</strong> {{ $order->customer->name }}</p>
            <p><strong>Phone:</strong> {{ $order->customer->phone }}</p>
            <p><strong>Address:</strong> {{ $order->customer->address }}</p>
        </div>

        <div class="card p-3 mb-4 shadow-sm">
            <h5>Order Summary</h5>
            <p><strong>Subtotal:</strong> ₹{{ number_format($order->subtotal, 2) }}</p>
            <p><strong>Discount:</strong> ₹{{ number_format($order->discount, 2) }}</p>
            <p><strong>Total:</strong> ₹{{ number_format($order->total, 2) }}</p>
            <p><strong>Remark:</strong> {{ $order->remark }}</p>
        </div>

        <div class="card p-3 shadow-sm">
            <h5>Items</h5>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Variant</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Addons</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ optional($item->variant)->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>
                                @if ($item->addon_ids)
                                    @foreach (json_decode($item->addon_ids) as $addonId)
                                        <span
                                            class="badge bg-secondary">{{ $item->item->addons->firstWhere('id', $addonId)->name ?? '' }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>₹{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
