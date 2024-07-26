@extends('tables.layout')

@section('content')

<div class="card mt-5">
  <h2 class="card-header">Edit Table</h2>
  <div class="card-body">

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('tables.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <form action="{{ route('tables.update', $table->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="inputStoreId" class="form-label"><strong>Store ID:</strong></label>
            <input 
                type="text" 
                name="store_id" 
                value="{{ old('store_id', $table->store_id) }}"
                class="form-control @error('store_id') is-invalid @enderror" 
                id="inputStoreId" 
                placeholder="Store ID">
            @error('store_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputName" class="form-label"><strong>Table Name:</strong></label>
            <input 
                type="text" 
                name="name" 
                value="{{ old('name', $table->name) }}"
                class="form-control @error('name') is-invalid @enderror" 
                id="inputName" 
                placeholder="Table Name">
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputCapacity" class="form-label"><strong>Capacity:</strong></label>
            <input 
                type="number" 
                name="capacity" 
                value="{{ old('capacity', $table->capacity) }}"
                class="form-control @error('capacity') is-invalid @enderror" 
                id="inputCapacity" 
                placeholder="Capacity">
            @error('capacity')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="qr_code_image" class="form-label"><strong>QR Code Image:</strong></label>
            @if ($table->qr_code_image)
                <div>
                    <img src="{{ asset('qr_codes/' . $table->qr_code_image) }}" alt="QR Code Image" style="max-width: 200px; height: auto;">
                </div>
            @endif
            <input 
                type="file" 
                name="qr_code_image" 
                class="form-control @error('qr_code_image') is-invalid @enderror" 
                id="qr_code_image" 
                accept="image/*">
            @error('qr_code_image')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
    </form>

  </div>
</div>

@endsection
