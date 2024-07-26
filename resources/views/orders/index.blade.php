@extends('layouts.store')

@section('content')
<div class="card mt-5">
    <h2 class="card-header text-center bg-black text-white">Order List</h2>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search orders by table name" value="{{ request()->query('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="50px">No</th>
                        <th>Table Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th width="250px">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $order->table->name }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td> 
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-info btn-sm me-1" href="#" data-id="{{ $order->id }}" data-bs-toggle="modal" data-bs-target="#orderModal">
                                    <i class="fa-solid fa-list"></i> Show
                                </a>
                                @if ($order->status !== 'checkout' && auth()->user()->isAdmin())
                                    <a class="btn btn-warning btn-sm me-1" href="{{ route('orders.checkout', $order->id) }}">
                                        <i class="fa fa-shopping-cart"></i> Checkout
                                    </a>
                                @endif
                                @if (auth()->user()->isAdmin())
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">There are no orders.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {!! $orders->links() !!}

    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="orderDetails">
                    <!-- Order details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show order details in modal
        document.querySelectorAll('.btn-info').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                const orderId = this.getAttribute('data-id'); // Get order ID from data attribute
                fetch(`/orders/${orderId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('orderDetails').innerHTML = data;
                        new bootstrap.Modal(document.getElementById('orderModal')).show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to load order details.');
                    });
            });
        });
    });
</script>

@endsection
