@extends('tables.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Checkout Orders for Table #{{ $table->id }}</h2>
    <div class="card-body">

        @if ($totalBill > 0)
            <p><strong>Total Bill:</strong> ${{ $totalBill }}</p>

            <form action="{{ route('tables.orders.checkout', $table->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="paymentMethod" class="form-label"><strong>Payment Method:</strong></label>
                    <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                        <option value="cash">Cash</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Complete Checkout</button>
            </form>
        @else
            <p><strong>No orders found for this table that can be checked out.</strong></p>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a class="btn btn-secondary btn-sm" href="{{ route('tables.show', $table->id) }}"><i class="fa fa-arrow-left"></i> Back to Table</a>
        </div>

    </div>
</div>

@endsection

