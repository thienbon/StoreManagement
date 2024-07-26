<div class="card mt-5">
    <h2 class="card-header">Order Details (ID: {{ $order->id }})</h2>
    <div class="card-body">
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $orderItem)
                <tr>
                    <td>{{ $orderItem->item->name }}</td>
                    <td>{{ $orderItem->quantity }}</td>
                    <td>${{ $orderItem->item->price }}</td>
                    <td>${{ $orderItem->quantity * $orderItem->item->price }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Total Amount</strong></td>
                    <td><strong>${{ $order->orderItems->sum(fn($orderItem) => $orderItem->quantity * $orderItem->item->price) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>