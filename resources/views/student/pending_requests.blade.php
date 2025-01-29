{{-- resources/views/student/pending_requests.blade.php --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')
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
                        <div>
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
