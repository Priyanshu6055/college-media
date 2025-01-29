<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Friends List</h1>

    <div class="row">
        @forelse($friends as $friend)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $friend->name }}</h5> <!-- Display friend's name -->
                        <!-- Add any additional details or actions related to the friend -->
                        <a href="{{ route('chat.index', $friend->id) }}" class="btn btn-success btn-sm mt-2">Send Message</a> <!-- Chat Link -->
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">You have no friends yet.</p> <!-- Message if no friends -->
        @endforelse
    </div>
</div>
@endsection
