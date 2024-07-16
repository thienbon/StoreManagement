@extends('orders.layout')
        
@section('content')
  
<div class="card mt-5">
  <h2 class="card-header">Create New Order</h2>
  <div class="card-body">
  
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('orders.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
  
        <div class="mb-3">
            <label for="inputTableId" class="form-label"><strong>Table:</strong></label>
            <select
                name="table_id"
                class="form-control @error('table_id') is-invalid @enderror"
                id="inputTableId">
                <option value="">Select Table</option>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}">{{ $table->id }}</option>
                @endforeach
            </select>
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
                        {{ $item->name }} (${{ number_format($item->price, 2) }})
                    </label>
                    <div class="input-group">
                        <button type="button" class="btn btn-outline-secondary btn-minus" data-id="{{ $item->id }}" data-price="{{ $item->price }}">-</button>
                        <input type="text" name="items[{{ $item->id }}][quantity]" class="form-control quantity" placeholder="Quantity" value="0" readonly>
                        <button type="button" class="btn btn-outline-secondary btn-plus" data-id="{{ $item->id }}" data-price="{{ $item->price }}">+</button>
                    </div>
                </div>
            @endforeach
            @error('items')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="totalAmount" class="form-label"><strong>Total Amount:</strong></label>
            <input type="text" id="totalAmount" class="form-control" value="0" readonly>
        </div>
  
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Order</button>
    </form>
  
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttonsMinus = document.querySelectorAll('.btn-minus');
    const buttonsPlus = document.querySelectorAll('.btn-plus');
    const totalAmount = document.getElementById('totalAmount');
    
    const updateTotalAmount = () => {
        let total = 0;
        document.querySelectorAll('.form-check').forEach(item => {
            const quantityInput = item.querySelector('.quantity');
            const price = item.querySelector('.btn-minus').getAttribute('data-price');
            const quantity = parseInt(quantityInput.value);
            if (!isNaN(quantity) && quantity > 0) {
                total += quantity * parseFloat(price);
            }
        });
        totalAmount.value = total.toFixed(2);
    };
    
    buttonsMinus.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            const input = document.querySelector(`input[name="items[${itemId}][quantity]"]`);
            let quantity = parseInt(input.value);
            if (quantity > 0) {
                input.value = quantity - 1;
                updateTotalAmount();
            }
        });
    });
    
    buttonsPlus.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            const input = document.querySelector(`input[name="items[${itemId}][quantity]"]`);
            let quantity = parseInt(input.value);
            input.value = quantity + 1;
            updateTotalAmount();
        });
    });
});
</script>
@endsection
