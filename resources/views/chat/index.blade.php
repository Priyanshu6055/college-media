<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(to bottom, #f3eaff, #ffffff);
        font-family: 'Segoe UI', sans-serif;
    }

    .chat-box {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(111, 66, 193, 0.1);
        padding: 15px;
        height: 350px;
        overflow-y: auto;
    }

    .message {
        margin-bottom: 10px;
        max-width: 75%;
        padding: 10px 15px;
        border-radius: 20px;
        position: relative;
        word-wrap: break-word;
        line-height: 1.4;
    }

    .message strong {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 0.9rem;
        color: #6f42c1;
    }

    .message.sent {
        background-color: #e0cfff;
        color: #4b0082;
        margin-left: auto;
        text-align: right;
    }

    .message.received {
        background-color: #f8f0ff;
        color: #333;
        margin-right: auto;
        text-align: left;
    }

    .tick {
        font-size: 0.8rem;
        color: #999;
        display: inline-block;
        margin-top: 5px;
        margin-left: 5px;
    }

    .chat-title {
        color: #6f42c1;
        font-weight: 600;
    }

    .form-control,
    .btn {
        border-radius: 12px;
    }

    .btn-primary {
        background-color: #6f42c1;
        border: none;
        padding: 10px 15px;
        border-radius: 50px;
    }

    .btn-primary:hover {
        background-color: #4b0082;
    }

    textarea.form-control {
        resize: none;
        height: 80px;
    }
</style>

<div class="container py-4">

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h3 class="chat-title mb-3">Chat with {{ $friend->name }}</h3>
    <hr>

    <!-- Display chat messages -->
    <div class="chat-box" id="chat-box">
        @foreach ($messages as $message)
            <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                <strong>{{ $message->sender->name }}</strong>
                {{ $message->message }}

                @if ($message->sender_id == auth()->id())
                    <div class="tick">
                        @if ($message->seen == 1)
                            &#10003;&#10003;
                        @elseif ($message->created_at < $friend->last_logged_in_at)
                            &#10003;
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Send message form -->
    <form action="{{ route('chat.send', $friend->id) }}" method="POST" id="message-form">
        @csrf

        <input type="hidden" name="receiver_id" value="{{ $friend->id }}">

        <textarea name="message" class="form-control mt-4" placeholder="Type your message..." required></textarea>

        <button class="btn btn-primary mt-3 w-100" type="submit">
            Send Message
        </button>
    </form>

</div>

<script>
    // Automatically scroll to the bottom after message is sent
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;

    // Form submission handler for auto-scroll
    document.getElementById('message-form').addEventListener('submit', function() {
        setTimeout(() => {
            chatBox.scrollTop = chatBox.scrollHeight;
        }, 100);
    });
</script>

@endsection
