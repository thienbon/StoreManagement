@extends('tables.layout')

@section('content')

<div class="card mt-5">
  <h2 class="card-header">Table Details</h2>
  <div class="card-body">
  
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('tables.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <div class="row mt-4">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Store ID:</strong> <br/>
                {{ $table->store_id }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Location:</strong> <br/>
                {{ $table->location }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Capacity:</strong> <br/>
                {{ $table->capacity }}
            </div>
        </div>
    </div>
  
  </div>
</div>
@endsection
