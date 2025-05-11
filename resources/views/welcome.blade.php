<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>College Media</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Softer animated gradient background */
        body {
            background: linear-gradient(-45deg, #dfe9f3, #f8f9fa, #e0c3fc, #8ec5fc);
            background-size: 400% 400%;
            animation: softGradient 12s ease infinite;
            color: #333;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes softGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: transform 0.4s ease;
            animation: fadeInCard 1.5s ease-out;
        }

        .card:hover {
            transform: translateY(-8px);
        }

        h2 {
            font-size: 2.5rem;
            color: #6a11cb;
            animation: fadeInUp 1s ease forwards;
        }

        p {
            color: #555;
            animation: fadeInUp 1.4s ease forwards;
        }

        .btn-custom {
            background-color: #6a11cb;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 24px;
            border-radius: 30px;
            transition: all 0.3s ease;
            animation: floatBtn 2s ease-in-out infinite;
        }

        .btn-custom:hover {
            background-color: #2575fc;
            box-shadow: 0 0 15px rgba(37, 117, 252, 0.3);
            transform: scale(1.05);
        }

        .btn-secondary {
            background-color: #fff;
            border: 2px solid #6a11cb;
            color: #6a11cb;
            font-weight: bold;
            padding: 10px 24px;
            border-radius: 30px;
            transition: all 0.3s ease;
            animation: floatBtn 2.2s ease-in-out infinite;
        }

        .btn-secondary:hover {
            background-color: #6a11cb;
            color: #fff;
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(106, 17, 203, 0.3);
        }

        @keyframes fadeInCard {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes floatBtn {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
    </style>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-5 text-center">
            <h2 class="mb-3">Welcome to College Media</h2>
            <p class="mb-4">Join the social hub for students, share moments, and connect with friends.</p>
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-custom btn-lg mb-3">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-secondary btn-lg mb-2">Log In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-custom btn-lg ml-2">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
