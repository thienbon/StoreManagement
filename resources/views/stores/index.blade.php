@extends('stores.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Stores</h2>
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
        @endif

        @if (auth()->user()->isAdmin())
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
                <a class="btn btn-success btn-sm" href="{{ route('stores.create') }}"> <i class="fa fa-plus"></i> Create New Store</a>
            </div>
        @endif

        <table class="table table-bordered table-striped mt-4">
            <thead>
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
                        <a class="btn btn-info btn-sm" href="{{ route('stores.show', $store->id) }}"><i class="fa-solid fa-list"></i> Show</a>

                        <a class="btn btn-warning btn-sm" href="{{ route('stores.tables', $store->id) }}"><i class="fa-solid fa-table"></i> Tables</a>

                        @if (auth()->user()->isAdmin())
                            <a class="btn btn-primary btn-sm" href="{{ route('stores.edit', $store->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                        
                            <form action="{{ route('stores.destroy', $store->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">There are no data.</td>
                </tr>
            @endforelse
            </tbody>

        </table>
        
        {!! $stores->links() !!}

    </div>
</div>  
@endsection
