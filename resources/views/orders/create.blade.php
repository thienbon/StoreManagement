@extends('orders.layout')
        
@section('content')
  
<div class="card mt-5">
  <h2 class="card-header">Create New Order for Table {{ $table->id }}</h2>
  <div class="card-body">
  
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('orders.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
  
        <div class="mb-3">
            <label for="inputTableId" class="form-label"><strong>Table ID:</strong></label>
            <input 
                type="text" 
                name="table_id" 
                class="form-control @error('table_id') is-invalid @enderror" 
                id="inputTableId" 
                value="{{ $table->id }}" <!-- Use the table ID here -->
                readonly>
            @error('table_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputStatus" class="form-label"><strong>Status:</strong></label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" id="inputStatus">
                <option value="prepare">Prepare</option>
                <option value="cooking">Cooking</option>
                <option value="done">Done</option>
                <option value="checkout">Checkout</option>
            </select>
            @error('status')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
  
        <div class="mb-3">
            <label for="inputItems" class="form-label"><strong>Items:</strong></label>
            @foreach ($items as $item)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="items[{{ $item->id }}][id]" value="{{ $item->id }}" id="item{{ $item->id }}">
                    <label class="form-check-label" for="item{{ $item->id }}">
                        {{ $item->name }} (${{ $item->price }})
                    </label>
                    <input type="text" name="items[{{ $item->id }}][quantity]" class="form-control" placeholder="Quantity">
                </div>
            @endforeach
            @error('items')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
  
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save</button>
    </form>
  
  </div>
</div>
@endsection
