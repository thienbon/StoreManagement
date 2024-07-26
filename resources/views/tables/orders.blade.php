@extends('layouts.store')

@section('content')

<div class="card mt-5">
    <div class="card-header text-center bg-black text-white">
        <h2 class="mb-0">Orders for Table {{ $table->id }}</h2>
    </div>
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        @if (auth()->user()->isUser())
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
            @if (!$orders->where('status', '!=', 'checkout')->count()) 
                <a class="btn btn-success btn-sm" href="{{ route('orders.create.for.table', $table->id) }}"><i class="fa fa-plus"></i> Create New Order</a>
            @endif
            <a class="btn btn-primary btn-sm" href="{{ route('tables.orders.checkout', $table->id) }}"><i class="fa fa-money-check-alt"></i> Checkout All Orders</a>
        </div>
        @endif

        <table class="table table-bordered table-striped mt-4">
            <thead class="bg-black text-white">
                <tr>
                    <th width="80px">No</th>
                    <th>Status</th>
                    <th width="350px">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                @if ($order->status !== 'checkout')
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->status }}</td>
                    @if (auth()->user()->isUser())
                    <td>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                            <a class="btn btn-secondary btn-sm" {{ $order->status === 'done' ? 'disabled' : '' }} href="{{ route('orders.orderMore', $order->id) }}"><i class="fa-solid fa-cart-plus"></i> Order More</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" {{ $order->status === 'done' ? 'disabled' : '' }}><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
                    </td>
                    @endif
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="order-details mt-4">
                            <h4>Order Details</h4>
                            <p><strong>Order ID:</strong> {{ $order->id }}</p>
                            <p><strong>Status:</strong> {{ $order->status }}</p>
                            <p><strong>Created At:</strong> {{ $order->created_at }}</p>
                            <p><strong>Items:</strong></p>
                            <table class="table table-bordered mt-2">
                                <thead class="bg-black text-white">
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Price per Unit</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->pivot->quantity }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>${{ number_format($item->pivot->quantity * $item->price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-black text-white">
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td>${{ number_format($order->items->sum(function($item) {
                                            return $item->pivot->quantity * $item->price;
                                        }), 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </td>
                </tr>
                @endif
            @empty
                <tr>
                    <td colspan="3">There are no orders for this table.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {!! $orders->links() !!}
    </div>
</div>

@endsection
