<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f4f2ff;
        font-family: 'Segoe UI', sans-serif;
    }

    .dashboard-title {
        color: #6a11cb;
        animation: fadeInDown 1s ease-in-out;
    }

    .card-table {
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 30px rgba(106, 17, 203, 0.1);
        padding: 2rem;
        animation: fadeInUp 1s ease-in-out;
    }

    .student-row {
        border-radius: 12px;
        transition: 0.3s;
        box-shadow: 0 0 0 rgba(0, 0, 0, 0);
    }

    .student-row:hover {
        box-shadow: 0 12px 24px rgba(106, 17, 203, 0.15);
        transform: translateY(-4px);
        background-color: #f0e9ff;
    }

    .table th {
        background-color: #6a11cb;
        color: white;
        border: none;
    }

    .table td {
        vertical-align: middle;
        border-top: none;
    }

    .btn-view {
        background: linear-gradient(to right, #6a11cb, #8e54e9);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 30px;
        transition: all 0.3s ease-in-out;
    }

    .btn-view:hover {
        background: linear-gradient(to right, #5a0f9c, #6f3efb);
        transform: scale(1.05);
    }

    .btn-delete {
        background-color: #ff4d6d;
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 30px;
        transition: all 0.3s ease-in-out;
    }

    .btn-delete:hover {
        background-color: #e60039;
        transform: scale(1.05);
    }

    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-3 dashboard-title">Teacher Dashboard</h1>
    <h2 class="text-center mb-4 dashboard-title">Student List</h2>

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-table">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 40%;">Email</th>
                    <th class="text-center" style="width: 30%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr class="student-row">
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td class="text-center">
                            <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-view me-2">View</a>

                            <form action="{{ route('teacher.students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
