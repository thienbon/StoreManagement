@extends('layouts.store')

@section('content')

<div class="container mt-5">
    <h2 class="text-center bg-black text-white p-3">Stores List</h2>
    
    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    @if (auth()->user()->isAdmin())
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
            <a class="btn btn-success btn-sm" href="{{ route('stores.create') }}">
                <i class="fa fa-plus"></i> Create New Store
            </a>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-4">
        <form action="{{ route('stores.index') }}" method="GET" class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search stores" value="{{ request()->query('search') }}" aria-label="Search">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div>

    <!-- Stores Table -->
    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th width="80px">No</th>
                <th>Name</th>
                <th>Details</th>
                <th width="250px">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($stores as $store)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->address }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('stores.show', $store->id) }}">
                            <i class="fa-solid fa-list"></i> Show
                        </a>

                        <a class="btn btn-warning btn-sm" href="{{ route('stores.tables', $store->id) }}">
                            <i class="fa-solid fa-table"></i> Tables
                        </a>

                        @if (auth()->user()->isAdmin())
                            <a class="btn btn-primary btn-sm" href="{{ route('stores.edit', $store->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        
                            <form action="{{ route('stores.destroy', $store->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">There are no data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {!! $stores->links() !!}
</div>

<!-- Store Details Modal -->
<div class="modal fade" id="storeModal" tabindex="-1" aria-labelledby="storeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeModalLabel">Store Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="storeDetails">
                    <!-- Store details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show store details in modal
        document.querySelectorAll('.btn-info').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                const storeId = this.getAttribute('href').split('/').pop();
                fetch(`/stores/${storeId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('storeDetails').innerHTML = data;
                        new bootstrap.Modal(document.getElementById('storeModal')).show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to load store details.');
                    });
            });
        });
    });
</script>

@endsection
