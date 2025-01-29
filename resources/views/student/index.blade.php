<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@extends('layouts.app')

@section('content')
<div class="container mt-2">

    <div class="sidebar bg-light rounded-2 p-3 mt-5">
        <a href="{{ route('friend-request.pending') }}" class="btn btn-primary mb-3 mt-2">Friend Requests</a>
        <a href="{{ route('student.friends') }}" class="btn btn-warning  mb-3 mt-2">Your Friends</a>
        <a href="{{ route('student.mutual-friends') }}" class="btn btn-success mb-3 mt-2">Mutual Friends</a>
        
    </div>

    <h1 class="text-center mb-3 mt-3">All Students List</h1>
    
    <div class="row">
        @foreach ($students as $student)
            @if ($student->id !== auth()->id()) <!-- Exclude the logged-in user -->
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $student->name }}</h5>
                            <form action="{{ route('friend-request.send') }}" method="POST">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $student->id }}">
                                <button type="submit" class="btn btn-primary btn-sm">Send Friend Request</button>
                            </form>
                            <!-- <a href="{{ route('chat.index', $student->id) }}" class="btn btn-success btn-sm mt-2">Send Message</a> -->
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
</body>
</html>