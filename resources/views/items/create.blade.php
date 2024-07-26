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
        <label for="inputName" class="form-label"><strong>Table Name:</strong></label>
        <input
            type="text"
            name="name"
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
            class="form-control @error('capacity') is-invalid @enderror"
            id="inputCapacity"
            placeholder="Capacity">
        @error('capacity')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
</form>
