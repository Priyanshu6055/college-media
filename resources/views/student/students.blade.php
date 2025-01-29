<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')
    <h1>List of All Students</h1>

    <ul>
        @foreach ($students as $student)
            <li>
                {{ $student->name }} ({{ $student->email }})

                <!-- Check if the logged-in user is not viewing their own profile -->
                @if (auth()->user()->id !== $student->id)
                    <!-- Check if a request has already been sent -->
                    @if (!auth()->user()->sentRequests->where('receiver_id', $student->id)->isEmpty())
                        <button disabled>Request Sent</button>
                    @else
                        <form action="{{ route('send.friend.request', $student->id) }}" method="POST">
                            @csrf
                            <button type="submit">Send Friend Request</button>
                        </form>
                    @endif
                @endif
            </li>
        @endforeach
    </ul>
@endsection
