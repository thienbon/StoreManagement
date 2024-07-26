@extends('layouts.store')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Edit Order</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('orders.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>

        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="inputTableId" class="form-label"><strong>Table ID:</strong></label>
                <input
                    type="text"
                    name="table_id"
                    value="{{ $order->table_id }}"
                    class="form-control @error('table_id') is-invalid @enderror"
                    id="inputTableId"
                    placeholder="Table ID">
                @error('table_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputStatus" class="form-label"><strong>Status:</strong></label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" id="inputStatus">
                    <option value="prepare" {{ $order->status == 'prepare' ? 'selected' : '' }}>Prepare</option>
                    <option value="cooking" {{ $order->status == 'cooking' ? 'selected' : '' }}>Cooking</option>
                    <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Done</option>
                    <option value="checkout" {{ $order->status == 'checkout' ? 'selected' : '' }}>Checkout</option>

                </select>
                @error('status')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputItems" class="form-label"><strong>Items:</strong></label>
                @foreach ($items as $item)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="items[{{ $item->id }}][id]" value="{{ $item->id }}" id="item{{ $item->id }}" {{ in_array($item->id, $order->orderItems->pluck('item_id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="item{{ $item->id }}">
                            {{ $item->name }} (${{ $item->price }})
                        </label>
                        <input type="text" name="items[{{ $item->id }}][quantity]" class="form-control" placeholder="Quantity" value="{{ $order->orderItems->where('item_id', $item->id)->first()->quantity ?? '' }}">
                    </div>
                @endforeach
                @error('items')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
        </form>

    </div>
</div>
@endsection
