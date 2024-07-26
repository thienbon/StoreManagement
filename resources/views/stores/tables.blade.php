@extends('layouts.store')

@section('content')

<div class="container mt-5">
    <h2 class="text-center bg-black text-white p-3">Tables for {{ $store->name }}</h2>

    <div class="card-body">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
            <a class="btn btn-success" href="{{ route('tables.create.for.store', ['store' => $store->id]) }}">
                <i class="fa fa-plus"></i> Add Table
            </a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead class="bg-black text-white">
                <tr>
                    <th width="80px">No</th>
                    <th>Table Name</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th width="400px">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($tables as $table)
                <tr class="{{ $loop->first ? 'bg-black text-white' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $table->name }}</td>
                    <td>{{ $table->capacity }}</td>
                    <td>{{ $table->status }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="#" data-id="{{ $table->id }}" data-bs-toggle="modal" data-bs-target="#tableModal">
                            <i class="fa fa-list"></i> Show
                        </a>
                        <a class="btn btn-primary btn-sm" href="{{ route('tables.edit', $table->id) }}">
                            <i class="fa fa-pen-to-square"></i> Edit
                        </a>
                        <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                        <form action="{{ route('tables.updateStatus', $table->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if ($table->status == 'available')
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fa fa-clipboard-list"></i> Order
                            </button>
                            @endif
                        </form>
                        <form action="{{ route('tables.unorder', $table->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if ($table->status == 'ordered')
                            <button type="submit" class="btn btn-secondary btn-sm">
                                <i class="fa fa-times"></i> Unorder
                            </button>
                            @endif
                        </form>
                        <a class="btn btn-secondary btn-sm" href="{{ route('tables.orders', $table->id) }}">
                            <i class="fa fa-list"></i> View Orders
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">There are no tables for this store.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {!! $tables->links() !!}
    </div>
</div>

<!-- Table Details Modal -->
<div class="modal fade" id="tableModal" tabindex="-1" aria-labelledby="tableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tableModalLabel">Table Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="tableDetails">
                    <!-- Table details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show table details in modal
        document.querySelectorAll('.btn-info').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                const tableId = this.getAttribute('data-id'); // Get table ID from data attribute
                fetch(`/tables/${tableId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('tableDetails').innerHTML = data;
                        new bootstrap.Modal(document.getElementById('tableModal')).show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to load table details.');
                    });
            });
        });
    });
</script>

@endsection
