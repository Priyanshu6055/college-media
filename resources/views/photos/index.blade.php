@extends('layouts.app')

@section('content')
<div class="container py-4">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(180deg, #f8f1ff, #ffffff);
            color: #4b0082;
            font-family: 'Segoe UI', sans-serif;
        }

        h3 {
            color: #6f42c1;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border-color: #d0b8ff;
        }

        .btn-primary {
            background-color: #6f42c1;
            border: none;
            border-radius: 12px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #4b0082;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(111, 66, 193, 0.12);
            overflow: hidden;
        }

        .card-img-top {
            height: 280px;
            object-fit: cover;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .card-body {
            background: #ffffff;
        }

        .card-title {
            color: #6f42c1;
            font-weight: 600;
        }

        .card-text,
        .text-muted {
            font-size: 0.9rem;
        }

        .privacy-label {
            color: #4b0082;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .card-img-top {
                height: 200px;
            }
        }
    </style>

    <h3 class="text-center mb-3">Upload a New Photo</h3>

    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
        @csrf
        <div class="mb-3">
            <label for="photo" class="form-label">Select Photo</label>
            <input type="file" name="photo" id="photo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="caption" class="form-label">Caption</label>
            <input type="text" name="caption" id="caption" class="form-control" placeholder="Write a caption...">
        </div>

        <div class="mb-3">
            <label for="privacy" class="form-label">Privacy</label>
            <select name="privacy" id="privacy" class="form-select">
                <option value="all">Publish for All</option>
                <option value="friends">Publish Only for Friends</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Upload Photo</button>
    </form>

    <hr class="mb-4">

    <h3 class="text-center mb-4">Your Photos</h3>

    <div class="row g-4">
        @forelse($photos as $photo)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                         class="card-img-top"
                         alt="Photo"
                         onerror="this.onerror=null;this.src='https://via.placeholder.com/300x200?text=Image+Not+Found';">
                    <div class="card-body">
                        <h5 class="card-title mb-1">{{ $photo->user->name }}</h5>
                        <p class="card-text mb-1">{{ $photo->caption }}</p>
                        <small class="text-muted d-block">{{ $photo->created_at->diffForHumans() }}</small>
                        <div class="privacy-label mt-2">
                            <strong>Privacy:</strong> {{ $photo->privacy == 'all' ? 'Public' : 'Friends Only' }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No photos uploaded yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
