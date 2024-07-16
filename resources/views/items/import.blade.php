@extends('items.layout')

@section('content')

<div class="card mt-5">
  <h2 class="card-header">Import Quantity</h2>
  <div class="card-body">

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('items.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <form action="{{ route('items.import.post') }}" method="POST" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="inputItemId" class="form-label"><strong>Item ID:</strong></label>
            <input 
                type="text" 
                name="item_id" 
                class="form-control @error('item_id') is-invalid @enderror" 
                id="inputItemId" 
                placeholder="Item ID">
            @error('item_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputQuantity" class="form-label"><strong>Quantity:</strong></label>
            <input 
                type="text" 
                name="quantity" 
                class="form-control @error('quantity') is-invalid @enderror" 
                id="inputQuantity" 
                placeholder="Quantity">
            @error('quantity')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus"></i> Import Quantity</button>
    </form>

  </div>
</div>
@endsection
