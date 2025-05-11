<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<x-app-layout></x-app-layout>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>College Media</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(180deg, #f5f0ff, #ffffff);
            font-family: 'Segoe UI', sans-serif;
            color: #4b0082;
        }

        .left-sidebar,
        .right-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            background-color: #f8f0ff;
            border-right: 1px solid #e0d4f7;
        }

        .right-sidebar {
            border-left: 1px solid #e0d4f7;
        }

        .content-area {
            background-color: #ffffff;
        }

        a {
            color: #6f42c1;
            text-decoration: none;
            transition: 0.2s;
        }

        a:hover {
            color: #4b0082;
            text-decoration: underline;
        }

        .sidebar-link {
            font-weight: 500;
            padding: 10px 14px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .sidebar-link:hover {
            background-color: #e0d4f7;
        }

        .animated-icon {
            font-size: 1.4rem;
            color: #6f42c1;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .animated-icon:hover {
            transform: scale(1.2);
            color: #4b0082;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(111, 66, 193, 0.12);
        }

        .card img {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            object-fit: cover;
            max-height: 500px;
        }

        @media (max-width: 768px) {

            .left-sidebar,
            .right-sidebar {
                display: none;
            }

            .content-area {
                padding: 1rem;
            }
        }

        @media (min-width: 1300px) {
            .content-area {
                padding-left: 6rem !important;
                padding-right: 6rem !important;
            }
        }

        .post-icons i {
            background-color: #f3e8ff;
            padding: 8px;
            border-radius: 50%;
            margin-right: 10px;
        }

        h5.card-title {
            color: #6f42c1;
        }

        .text-muted {
            font-size: 0.9rem;
        }


        .text-purple {
            color: #6f42c1 !important;
        }

        .fixed-bottom a:hover {
            color: #4b0082 !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Left Sidebar -->
            <div class="col-md-3 d-none d-md-block left-sidebar p-3">
                <div class="d-flex flex-column gap-3">
                    @auth
                    @if(Auth::user()->role === 'student')
                    <a href="{{ route('students.list') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <i class="bi bi-people-fill animated-icon"></i> All Students
                    </a>

                    <a href="{{ route('friend-request.pending') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <i class="bi bi-person-plus-fill animated-icon"></i> Friend Requests
                    </a>

                    <a href="{{ route('student.friends') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <i class="bi bi-people animated-icon"></i> Your Friends
                    </a>

                    <a href="{{ route('student.mutual-friends') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <i class="bi bi-person-check-fill animated-icon"></i> Mutual Friends
                    </a>
                    @endif
                    @endauth

                    <a href="{{ route('photos.index') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <i class="bi bi-upload animated-icon"></i> Upload Photos
                    </a>

                    @auth
                    @if(Auth::user()->role === 'teacher')
                    <a href="{{ route('teacher.dashboard') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <i class="bi bi-speedometer2 animated-icon"></i> Teacher Dashboard
                    </a>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-5 col-12 content-area py-4 px-3 mx-auto">

                <h4 class="mb-4 fw-bold text-purple">All Posts</h4>
                <div class="row">
                    @foreach($photos as $photo)
                    <div class="col-12 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $photo->file_path) }}" class="card-img-top" alt="Photo" />
                            <div class="card-body">
                                <h5 class="card-title">{{ $photo->user->name ?? 'Unknown' }}</h5>
                                <p class="card-text">{{ $photo->caption }}</p>
                                <small class="text-muted">
                                    {{ $photo->created_at->diffForHumans() }} •
                                    {{ $photo->privacy === 'all' ? 'Public' : 'Friends Only' }}
                                </small>

                                <div class="mt-3 post-icons d-flex">
                                    <i class="bi bi-heart animated-icon"></i>
                                    <i class="bi bi-chat animated-icon"></i>
                                    <i class="bi bi-send animated-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-md-3 d-none d-md-block right-sidebar p-3">
                <h6 class="text-purple fw-bold">Suggestions</h6>
                <ul class="list-unstyled mt-3">
                    <li><i class="bi bi-person-plus-fill text-purple me-2"></i>Follow new users</li>
                    <li><i class="bi bi-search text-purple me-2"></i>Explore more</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Nav -->
    <div class="d-md-none d-block fixed-bottom bg-white border-top shadow-sm">
        <div class="d-flex justify-content-around align-items-center py-2">
            <a href="{{ route('students.list') }}" class="text-decoration-none text-center text-purple">
                <i class="bi bi-people-fill fs-4"></i>
            </a>
            <a href="{{ route('friend-request.pending') }}" class="text-decoration-none text-center text-purple">
                <i class="bi bi-person-plus-fill fs-4"></i>
            </a>
            <a href="{{ route('photos.index') }}" class="text-decoration-none text-center text-purple">
                <i class="bi bi-upload fs-4"></i>
            </a>
            <a href="{{ route('student.friends') }}" class="text-decoration-none text-center text-purple">
                <i class="bi bi-person-check fs-4"></i>
            </a>
            <a href="{{ route('student.mutual-friends') }}" class="text-decoration-none text-center text-purple">
                <i class="bi bi-people fs-4"></i>
            </a>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>