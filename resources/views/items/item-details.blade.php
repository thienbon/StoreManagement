<div class="row">
    <div class="col-md-4">
        <img src="{{ asset($item->image) }}" class="img-fluid" alt="{{ $item->name }}">
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <strong>Name:</strong> <br/>
            {{ $item->name }}
        </div>
        <div class="form-group mt-2">
            <strong>Price:</strong> <br/>
            {{ $item->price }}
        </div>
        <div class="form-group mt-2">
            <strong>Description:</strong> <br/>
            {{ $item->description }}
        </div>
        <div class="form-group mt-2">
            <strong>Quantity in Stock:</strong> <br/>
            {{ $item->quantity_in_stock }}
        </div>
    </div>
</div>
