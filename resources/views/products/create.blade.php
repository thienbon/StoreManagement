@extends('products.layout')

@section('content')

<div class="card mt-5">
  <h2 class="card-header">Create New Product</h2>
  <div class="card-body">

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('products.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="inputItemID" class="form-label"><strong>Item ID:</strong></label>
            <select name="item_id" id="inputItemID" class="form-control @error('item_id') is-invalid @enderror">
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->name }}</option>
                @endforeach
            </select>
            @error('item_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputName" class="form-label"><strong>Name:</strong></label>
            <input 
                type="text" 
                name="name" 
                class="form-control @error('name') is-invalid @enderror" 
                id="inputName" 
                placeholder="Name">
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputQuantity" class="form-label"><strong>Quantity:</strong></label>
            <input 
                type="number" 
                name="quantity" 
                class="form-control @error('quantity') is-invalid @enderror" 
                id="inputQuantity" 
                placeholder="Quantity">
            @error('quantity')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save</button>
    </form>

  </div>
</div>
@endsection
