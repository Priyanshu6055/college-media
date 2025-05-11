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

    .btn-danger {
        background-color: #dc3545;
        border: none;
        border-radius: 50px;
        padding: 10px 20px;
        text-transform: uppercase;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .list-group-item {
        border: 1px solid #6f42c1;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(111, 66, 193, 0.1);
        background-color: #f8f9fa;
        transition: transform 0.3s ease;
    }

    .list-group-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(111, 66, 193, 0.15);
    }

    .empty-message {
        color: #6f42c1;
        font-size: 1.2rem;
        text-align: center;
    }

    h3 {
        text-align: center;
        color: #6f42c1;
        margin-bottom: 30px;
        font-weight: 700;
    }

    .request-info {
        color: #6f42c1;
        font-weight: 600;
    }

</style>

<div class="container d-flex justify-content-center mt-4">
    <div class="w-75">
        <h3 class="text-center mb-4">Pending Friend Requests</h3>

        @if($pendingRequests->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                No pending friend requests.
            </div>
        @else
            <div class="list-group">
                @foreach($pendingRequests as $request)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="request-info">
                            <strong>{{ $request->sender->name }}</strong> ({{ $request->sender->email }})
                        </div>
                        <div>
                            <form action="{{ route('friend-request.accept') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="request_id" value="{{ $request->id }}">
                                <button type="submit" class="btn btn-success btn-sm me-2">Accept</button>
                            </form>
                            <form action="{{ route('friend-request.reject') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="request_id" value="{{ $request->id }}">
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
