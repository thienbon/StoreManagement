@extends('layouts.store')

@section('content')

<div class="card mt-5">
    <h2 class="card-header text-center bg-black text-white">Tables List</h2>
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif

        @if (auth()->user()->isAdmin())
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
                <a class="btn btn-success" href="{{ route('tables.create') }}"><i class="fa fa-plus"></i> Add Table</a>
            </div>
        @endif

        <form action="{{ route('tables.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search tables" value="{{ request()->query('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="80px">No</th>
                        <th>Store Name</th>
                        <th>Table Name</th>
                        <th>Capacity</th>
                        <th>Status</th>
                        <th width="400px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tables as $table)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $table->store->name }}</td>
                            <td>{{ $table->name }}</td>
                            <td>{{ $table->capacity }}</td>
                            <td>{{ $table->status }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-info btn-sm me-1 show-table" data-id="{{ $table->id }}" href="#">
                                        <i class="fa fa-eye"></i> Show
                                    </a>

                                    @if (auth()->user()->isAdmin())
                                        <a class="btn btn-primary btn-sm me-1" href="{{ route('tables.edit', $table->id) }}">
                                            <i class="fa fa-pen-to-square"></i> Edit
                                        </a>
                                        <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('tables.updateStatus', $table->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        @if ($table->status == 'available')
                                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-clipboard-list"></i> Order</button>
                                        @endif
                                    </form>

                                    <form action="{{ route('tables.unorder', $table->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        @if ($table->status == 'ordered')
                                            <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-times"></i> Unorder</button>
                                        @endif
                                    </form>

                                    @if ($table->status == 'ordered' || auth()->user()->isAdmin())
                                        <a class="btn btn-secondary btn-sm" href="{{ route('tables.orders', $table->id) }}">
                                            <i class="fa fa-list"></i> View Orders
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">There are no tables.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

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
        document.querySelectorAll('.show-table').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const tableId = this.getAttribute('data-id');
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
