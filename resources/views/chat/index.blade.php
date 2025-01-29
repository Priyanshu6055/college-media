<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')

<div class="container">

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h3>Chat with {{ $friend->name }}</h3> <!-- Display friend's name -->
    <hr>
    
    <!-- Display chat messages -->
    <div class="chat-box mt-4" style="height: 300px; overflow-y: scroll;">
    @foreach ($messages as $message)
        <div class="message">
            <strong>{{ $message->sender->name }}:</strong> {{ $message->message }}

            @if ($message->sender_id == auth()->id())
                @if ($message->seen == 1)
                    <span>&#10003;&#10003;</span> <!-- Double tick if the message is seen -->
                @elseif ($message->created_at < $friend->last_logged_in_at)
                    <span>&#10003;</span> <!-- Single tick if the friend has logged in -->
                @else
                    <span></span> <!-- No tick if not seen -->
                @endif
            @endif
        </div>
    @endforeach
</div>

    <!-- Send message form -->
    <form action="{{ route('chat.send', $friend->id) }}" method="POST">
        @csrf
        
        <!-- Hidden receiver ID -->
        <input type="hidden" name="receiver_id" value="{{ $friend->id }}">

        <!-- Message textarea -->
        <textarea name="message" class="form-control mt-4" placeholder="Type your message..." required></textarea>
        
        <button class="btn btn-primary mt-3" type="submit">Send</button>
    </form>

</div>

@endsection
