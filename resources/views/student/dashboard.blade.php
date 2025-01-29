<h1>Welcome Student!</h1>

@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Welcome, {{ Auth::user()->name }}</h3>
    <!-- Link to Pending Friend Requests -->
    <a href="{{ route('friend-request.pending') }}" 
    class="btn btn-primary">View Pending Friend Requests</a>
</div>
@endsection
