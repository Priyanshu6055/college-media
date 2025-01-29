<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<x-app-layout>

</x-app-layout>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram-Like Responsive Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .left-sidebar,
        .right-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
        }

        .content-area {
            height: 100vh;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {

            .left-sidebar,
            .right-sidebar {
                height: auto;
                max-height: 200px;
                overflow-y: visible;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">



            <!-- Left Sidebar -->
            <div class="col-md-3 col-12 left-sidebar p-1">
                <ul class="list-unstyled d-flex flex-column gap-2" id="sidebar-links">

                    <div class="btn-group w-100">
                        <a href="{{ route('students.list') }}" class="btn btn-secondary btn-sm w-100 text-start">
                            Friend List
                        </a>
                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu w-100">
                            <li><a class="dropdown-item" href="{{ route('friend-request.pending') }}">Friend Requests</a></li>
                            <li><a class="dropdown-item" href="{{ route('student.friends') }}">Your Friends</a></li>
                            <li><a class="dropdown-item" href="{{ route('student.mutual-friends') }}">Mutual Friends</a></li>
                        </ul>
                    </div>

                    <x-responsive-nav-link :href="route('photos.index')" :active="request()->routeIs('photos.index')" class="w-100">
                        {{ __('Upload Photos') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('teacher.dashboard')" :active="request()->routeIs('dashboard')" class="w-100">
                        {{ __('Teacher Dashboard') }}
                    </x-responsive-nav-link>

                </ul>
            </div>


            <!-- Main Content Area -->
            <div class="col-md-6 col-12 content-area p-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('All Posts') }}
                </h2>
                <div class="row mt-4">
                    @foreach($photos as $photo)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $photo->file_path) }}" class="card-img-top" alt="Photo">
                            <div class="card-body">
                                <h5 class="card-title font-semibold text-xl text-gray-800 leading-tight">{{ $photo->user ? $photo->user->name : 'Unknown User' }}</h5>
                                <p class="card-text">{{ $photo->caption }}</p>
                                <small class="text-muted">{{ $photo->created_at->diffForHumans() }}</small>
                                <div class="mt-2 small">
                                    <strong>Privacy: </strong>
                                    {{ $photo->privacy == 'all' ? 'Public' : 'Friends Only' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-md-3 col-12 right-sidebar p-3">

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>