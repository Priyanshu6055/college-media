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

    .btn-primary {
        background-color: #6f42c1;
        border: none;
        border-radius: 50px;
        padding: 10px 20px;
        text-transform: uppercase;
    }

    .btn-primary:hover {
        background-color: #4b0082;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        border-radius: 50px;
        padding: 10px 20px;
        text-transform: uppercase;
    }

    .btn-success:hover {
        background-color: #218838;
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

    h1 {
        text-align: center;
        color: #6f42c1;
        margin-bottom: 30px;
        font-weight: 700;
    }

</style>

<div class="container mt-4">
    <h1>Mutual Friends</h1>
    <div class="row">
        @foreach ($mutualFriends as $friend)
        <div class="col-md-4 mb-3">
            <div class="card friend-card">
                <div class="card-body">
                    <h5 class="card-title">{{ $friend->name }}</h5>

                    <!-- Friend Request Button -->
                    @if (!auth()->user()->friends->contains($friend->id)) 
                    <!-- Check if not already friends -->
                    <form action="{{ route('friend-request.send', $friend->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Send Friend Request</button>
                    </form>
                    @else
                    <!-- Chat Button if already friends -->
                    <a href="{{ route('chat', $friend->id) }}" class="btn btn-success mt-2">Chat</a>
                    @endif

                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($mutualFriends->isEmpty())
    <p class="empty-message">You have no mutual friends yet.</p>
    @endif

</div>

@endsection
