<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(to bottom, #f3eaff, #ffffff);
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 1200px;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(111, 66, 193, 0.1);
        background-color: #ffffff;
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        color: #6f42c1;
        font-weight: 600;
    }

    .btn-success {
        background-color: #6f42c1;
        border: none;
        border-radius: 50px;
        padding: 10px 20px;
        text-transform: uppercase;
    }

    .btn-success:hover {
        background-color: #4b0082;
    }

    .friend-card {
        transition: transform 0.3s ease;
    }

    .friend-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(111, 66, 193, 0.15);
    }

    .empty-message {
        color: #6f42c1;
        font-size: 1.2rem;
        text-align: center;
    }

</style>

<div class="container mt-4">
    <h1 class="text-center mb-4 text-purple">Friends List</h1>

    <div class="row">
        @forelse($friends as $friend)
        <div class="col-md-4 mb-3">
            <div class="card friend-card">
                <div class="card-body">
                    <h5 class="card-title">{{ $friend->name }}</h5> <!-- Display friend's name -->
                    <!-- Add any additional details or actions related to the friend -->
                    <a href="{{ route('chat.index', $friend->id) }}" class="btn btn-success btn-sm mt-2">Send Message</a> <!-- Chat Link -->
                </div>
            </div>
        </div>
        @empty
        <p class="empty-message">You have no friends yet. Add some friends to start chatting!</p> <!-- Message if no friends -->
        @endforelse
    </div>
</div>

@endsection
