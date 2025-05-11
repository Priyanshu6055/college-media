<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(to bottom, #f3eaff, #ffffff);
        font-family: 'Segoe UI', sans-serif;
    }

    h1 {
        text-align: center;
        color: #6f42c1;
        margin-bottom: 30px;
        font-weight: 700;
    }

    .list-group {
        margin-top: 20px;
    }

    .list-group-item {
        background-color: #ffffff;
        border: 1px solid #6f42c1;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 10px;
        box-shadow: 0 4px 10px rgba(111, 66, 193, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-group-item:hover {
        background-color: #f3eaff;
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(111, 66, 193, 0.2);
    }

    .btn-primary {
        background-color: #6f42c1;
        border: none;
        border-radius: 50px;
        padding: 8px 20px;
        color: white;
        text-transform: uppercase;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #4b0082;
    }

    .btn-secondary {
        background-color: #c5c5c5;
        border: none;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: bold;
    }

    .btn-secondary:hover {
        background-color: #a0a0a0;
    }

    .no-request-message {
        color: #6f42c1;
        font-size: 1.1rem;
        font-weight: 600;
    }

</style>

<div class="container mt-4">
    <h1>List of All Students</h1>

    @if($students->isEmpty())
        <p class="text-center no-request-message">No students found in the system.</p>
    @else
        <div class="list-group">
            @foreach ($students as $student)
                <div class="list-group-item">
                    <div>
                        <strong>{{ $student->name }}</strong> ({{ $student->email }})
                    </div>

                    <!-- Check if the logged-in user is not viewing their own profile -->
                    @if (auth()->user()->id !== $student->id)
                        <!-- Check if a request has already been sent -->
                        @if (!auth()->user()->sentRequests->where('receiver_id', $student->id)->isEmpty())
                            <button class="btn btn-secondary" disabled>Request Sent</button>
                        @else
                            <form action="{{ route('send.friend.request', $student->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Send Friend Request</button>
                            </form>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
