@extends('tables.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Add New Table</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('tables.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>

        <form action="{{ route('tables.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="inputStoreId" class="form-label"><strong>Store:</strong></label>
                <select
                    name="store_id"
                    class="form-control @error('store_id') is-invalid @enderror"
                    id="inputStoreId">
                    <option value="">Select Store</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
                @error('store_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputLocation" class="form-label"><strong>Location:</strong></label>
                <input
                    type="text"
                    name="location"
                    class="form-control @error('location') is-invalid @enderror"
                    id="inputLocation"
                    placeholder="Location">
                @error('location')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputCapacity" class="form-label"><strong>Capacity:</strong></label>
                <input
                    type="number"
                    name="capacity"
                    class="form-control @error('capacity') is-invalid @enderror"
                    id="inputCapacity"
                    placeholder="Capacity">
                @error('capacity')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </form>

    </div>
</div>
@endsection
