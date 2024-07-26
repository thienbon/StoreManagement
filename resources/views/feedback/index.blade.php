
@extends('layouts.store')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Feedback List</h2>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
            <a class="btn btn-success btn-sm" href="{{ route('feedback.create') }}"> <i class="fa fa-plus"></i> Submit Feedback</a>
        </div>

        @forelse ($feedbacks as $feedback)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $feedback->customer_name }}</h5>
                    <p class="card-text">{{ $feedback->content }}</p>
                    <p class="card-text"><small class="text-muted">Submitted on {{ $feedback->created_at->format('d M Y') }}</small></p>
                </div>
            </div>
        @empty
            <p>No feedback yet.</p>
        @endforelse

        {!! $feedbacks->links() !!}
    </div>
</div>
@endsection