<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(to right, #f6f0fc, #f3e7fe);
        font-family: 'Segoe UI', sans-serif;
    }

    .auth-card {
        max-width: 480px;
        margin: auto;
        margin-top: 80px;
        background-color: white;
        padding: 2rem 2.5rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(106, 17, 203, 0.12);
        animation: fadeIn 0.8s ease-in-out;
    }

    label, input {
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #6a11cb;
        box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.2);
    }

    .form-control {
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-purple {
        background: linear-gradient(to right, #6a11cb, #8e54e9);
        color: white;
        border-radius: 30px;
        padding: 10px 24px;
        transition: all 0.3s ease;
    }

    .btn-purple:hover {
        background: linear-gradient(to right, #5310b5, #7e3ffc);
        transform: scale(1.05);
    }

    .fade-link {
        color: #6a11cb;
        text-decoration: none;
        font-weight: 500;
    }

    .fade-link:hover {
        color: #4c0c9b;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<x-guest-layout>
    <div class="auth-card">
        <h2 class="text-center mb-4 fw-bold text-purple">Welcome Back</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-3 text-success text-sm text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username" class="form-control">
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-danger" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="form-control">
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-danger" />
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember_me" class="form-check-input">
                <label class="form-check-label" for="remember_me">Remember Me</label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="fade-link text-sm">
                        Forgot your password?
                    </a>
                @endif

                <button type="submit" class="btn btn-purple">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
