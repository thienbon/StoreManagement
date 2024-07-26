@extends('items.layout')

@section('content')

<div class="card mt-5 shadow-sm">
    <div class="card-header text-center bg-dark text-white">
        <h2 class="mb-0">Food Items</h2>
    </div>
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
            <a class="btn btn-success btn-sm me-2" href="{{ route('items.create') }}">
                <i class="fa fa-plus"></i> Create New Item
            </a>
            <a href="#" class="btn btn-info btn-sm" id="importQuantityBtn">
                <i class="fa fa-upload"></i> Import Quantity
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="50px">No</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td><img src="{{ asset($item->image) }}" class="img-thumbnail" width="100" height="100" alt="{{ $item->name }}"></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity_in_stock }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-info btn-sm me-1 show-item" data-id="{{ $item->id }}">
                                    <i class="fa fa-eye"></i> Show
                                </a>
                                <a class="btn btn-primary btn-sm me-1" href="{{ route('items.edit', $item->id) }}">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">There are no items.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {!! $items->links() !!}
        </div>
    </div>
</div>

<!-- Item Details Modal -->
<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemModalLabel">Item Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="itemDetails">
                    <!-- Item details will be loaded here -->
                </div>
            </div>
        </div>
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

        // Show item details in modal
        document.querySelectorAll('.show-item').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                fetch(`/items/${itemId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('itemDetails').innerHTML = data;
                        new bootstrap.Modal(document.getElementById('itemModal')).show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to load item details.');
                    });
            });
        });
    });
</script>

@endsection
