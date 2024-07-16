@extends('items.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Items</h2>
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
            <a class="btn btn-success btn-sm" href="{{ route('items.create') }}"> <i class="fa fa-plus"></i> Create New Item</a>
            <a href="#" class="btn btn-info btn-sm" id="importQuantityBtn"> <i class="fa fa-plus"></i> Import Quantity</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Quantity in Stock</th>
                    <th width="250px">Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity_in_stock }}</td>
                    <td>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST">

                            <a class="btn btn-info btn-sm" href="{{ route('items.show', $item->id) }}"><i class="fa-solid fa-list"></i> Show</a>

                            <a class="btn btn-primary btn-sm" href="{{ route('items.edit', $item->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">There are no items.</td>
                </tr>
            @endforelse
            </tbody>

        </table>
        
        {!! $items->links() !!}

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('importQuantityBtn').addEventListener('click', function(event) {
            event.preventDefault();

            // AJAX request to import quantity
            fetch("{{ route('items.import.quantity') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Reload the page or update DOM as needed
                    window.location.reload();
                } else {
                    alert('Failed to import quantity.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to import quantity.');
            });
        });
    });
</script>

@endsection
