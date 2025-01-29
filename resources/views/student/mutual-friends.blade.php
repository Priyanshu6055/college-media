<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- resources/views/student/mutual-friends.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Mutual Friends</h1>
    <div class="row">
        @foreach ($mutualFriends as $friend)
            <div class="col-md-4 mb-3">
                <div class="card">
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
</div>
@endsection
