@extends('customer.layout')
    

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Order </h2>
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('customer.create') }}"><i class="fa fa-plus"></i> Create Your Order</a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Table ID</th>
                    <th>Status</th>
                    <th width="250px">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $order->table_id }}</td>
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
            @empty
                <tr>
                    <td colspan="4">There are no data.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {!! $orders->links() !!}
    </div>
</div>
@endsection

