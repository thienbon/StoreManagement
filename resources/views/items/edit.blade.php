@extends('items.layout')

@section('content')

<div class="card mt-5">
  <h2 class="card-header">Edit Item</h2>
  <div class="card-body">
  
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('items.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
  
        <div class="mb-3">
            <label for="inputName" class="form-label"><strong>Name:</strong></label>
            <input 
                type="text" 
                name="name" 
                value="{{ $item->name }}"
                class="form-control @error('name') is-invalid @enderror" 
                id="inputName" 
                placeholder="Name">
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputPrice" class="form-label"><strong>Price:</strong></label>
            <input 
                type="text" 
                name="price" 
                value="{{ $item->price }}"
                class="form-control @error('price') is-invalid @enderror" 
                id="inputPrice" 
                placeholder="Price">
            @error('price')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
  
        <div class="mb-3">
            <label for="inputDescription" class="form-label"><strong>Description:</strong></label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                style="height:150px" 
                name="description" 
                id="inputDescription" 
                placeholder="Description">{{ $item->description }}</textarea>
            @error('description')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputQuantityInStock" class="form-label"><strong>Quantity in Stock:</strong></label>
            <input 
                type="text" 
                name="quantity_in_stock" 
                value="{{ $item->quantity_in_stock }}"
                class="form-control @error('quantity_in_stock') is-invalid @enderror" 
                id="inputQuantityInStock" 
                placeholder="Quantity in Stock">
            @error('quantity_in_stock')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputImage" class="form-label"><strong>Image:</strong></label>
            <input 
                type="file" 
                name="image" 
                class="form-control @error('image') is-invalid @enderror" 
                id="inputImage">
            @error('image')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
            @if ($item->image)
                <div class="mt-2">
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="img-thumbnail" width="200">
                </div>
            @endif
        </div>
  
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
    </form>
  
  </div>
</div>
@endsection
