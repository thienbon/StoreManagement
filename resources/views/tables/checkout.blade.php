@extends('tables.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Checkout Orders for Table {{ $table->id }}</h2>
    <div class="card-body">

        <h4>Orders:</h4>
        <ul>
            @foreach ($orders as $order)
                <li>Order #{{ $order->id }} - Status: {{ $order->status }}</li>
                <ul>
                    @foreach ($order->items as $item)
                        <li>{{ $item->name }} - Quantity: {{ $item->pivot->quantity }} - Price: ${{ $item->price }}</li>
                    @endforeach
                </ul>
            @endforeach
        </ul>

        <h4>Total: ${{ number_format($total, 2) }}</h4>

        <form action="{{ route('tables.orders.checkout.process', $table->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="payment_method"><strong>Payment Method:</strong></label>
                <select name="payment_method" id="payment_method" class="form-control">
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3"><i class="fa fa-money-check-alt"></i> Confirm Checkout</button>
        </form>

    </div>
</div>

@endsection
