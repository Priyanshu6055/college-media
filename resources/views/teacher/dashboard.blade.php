<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')

<div class="container mt-4 ">
    <h1 class="mb-4 text-center">Teacher Dashboard</h1>
    <h2 class="mb-4 text-center">Student List</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <!-- Table Container -->
    <div class="table-responsive shadow-sm rounded-lg bg-white p-3">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td class="d-flex">
                            <!-- View Button -->
                            <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-primary btn-sm mx-2">View</a>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('teacher.students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
