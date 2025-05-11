<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #f3eaff, #ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        h1 {
            text-align: center;
            color: #6f42c1;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #6f42c1;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(111, 66, 193, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
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

        .btn-sm {
            font-size: 14px;
            padding: 5px 10px;
        }

        .col-md-4 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">All Students List</h1>
    
    <div class="row">
        @foreach ($students as $student)
            @if ($student->id !== auth()->id()) <!-- Exclude the logged-in user -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $student->name }}</h5>
                            <form action="{{ route('friend-request.send') }}" method="POST">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $student->id }}">
                                <button type="submit" class="btn btn-primary btn-sm">Send Friend Request</button>
                            </form>
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
