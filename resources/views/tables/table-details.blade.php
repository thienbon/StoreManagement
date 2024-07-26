<div class="row">
    <div class="col-md-4">
        @if ($table->qr_code_image)
            <img src="{{ asset('qr_codes/' . $table->qr_code_image) }}" class="img-fluid" alt="QR Code Image">
        @else
            No QR Code Image
        @endif
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <strong>Store:</strong> <br/>
            {{ $table->store->name }}
        </div>
        <div class="form-group mt-2">
            <strong>Table Name:</strong> <br/>
            {{ $table->name }}
        </div>
        <div class="form-group mt-2">
            <strong>Capacity:</strong> <br/>
            {{ $table->capacity }}
        </div>
    </div>
</div>
