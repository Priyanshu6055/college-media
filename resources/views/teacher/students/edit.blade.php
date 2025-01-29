<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg">
                <div class="card-header text-center">
                    <h1 style="font-family: 'Arial', sans-serif; color: #4CAF50;">Edit Student Details</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.students.update', $student->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name input field -->
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $student->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert" style="color: red;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email input field -->
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email', $student->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert" style="color: red;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Update Button -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-secondary px-6 py-3 text-black rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <i class="fas fa-check"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Container styles */
    .container {
        margin-top: 50px;
    }

    /* Card Styles */
    .card {
        border-radius: 15px;
        background-color: #f8f9fa;
    }

    /* Heading Styles */
    .card-header h1 {
        font-family: 'Arial', sans-serif;
        color: #4CAF50;
        font-size: 2rem;
        font-weight: bold;
    }

    /* Input fields styling */
    .form-control {
        border-radius: 10px;
        font-size: 1em;
        padding: 15px;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 10px rgba(76, 175, 80, 0.2);
    }

    /* Button Styling */
    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 50px;
        font-size: 1.2em;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .btn-primary:focus {
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.5);
    }

    /* Spacing for the button */
    .btn-primary i {
        margin-right: 8px;
    }

    /* Form margin and padding */
    .form-group {
        margin-bottom: 30px;
    }

    /* Error Message Styling */
    .invalid-feedback {
        font-size: 0.875em;
        margin-top: 5px;
    }
</style>
@endsection
