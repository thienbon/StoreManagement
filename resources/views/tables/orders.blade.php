@extends('tables.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Orders for Table {{ $table->id }}</h2>
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
            <a class="btn btn-success btn-sm" href="{{ route('orders.create.for.table', $table->id) }}"><i class="fa fa-plus"></i> Create New Order</a>
            <a class="btn btn-primary btn-sm" href="{{ route('tables.orders.checkout', $table->id) }}"><i class="fa fa-money-check-alt"></i> Checkout All Orders</a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Status</th>
                    <th width="250px">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                @if ($order->status !== 'checkout')
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                            <a class="btn btn-info btn-sm" href="{{ route('orders.show', $order->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('orders.edit', $order->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
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
