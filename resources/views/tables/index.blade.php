@extends('tables.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Tables</h2>
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif

        @if (auth()->user()->isAdmin())
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success" href="{{ route('tables.create') }}"><i class="fa fa-plus"></i> Add Table</a>
        </div>
        @endif

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Store Name</th>
                    <th>Location</th>
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
                        <td>{{ $table->location }}</td>
                        <td>{{ $table->capacity }}</td>
                        <td>{{ $table->status }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('tables.show', $table->id) }}"><i class="fa fa-list"></i> Show</a>
                            
                            @if (auth()->user()->isAdmin())
                                <a class="btn btn-primary btn-sm" href="{{ route('tables.edit', $table->id) }}"><i class="fa fa-pen-to-square"></i> Edit</a>
                                <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
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
                                <a class="btn btn-secondary btn-sm" href="{{ route('tables.orders', $table->id) }}"><i class="fa fa-list"></i> View Orders</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">There are no tables.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {!! $tables->links() !!}

    </div>
</div>
@endsection