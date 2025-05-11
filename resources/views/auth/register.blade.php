<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(to right, #eae2f8, #f8f0ff);
        font-family: 'Segoe UI', sans-serif;
    }

    .auth-card {
        max-width: 600px;
        margin: auto;
        margin-top: 50px;
        background-color: white;
        padding: 2rem 2.5rem;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(106, 17, 203, 0.1);
        animation: fadeIn 1s ease-out;
    }

    label, select, input {
        font-size: 1rem;
    }

    .form-control:focus, select:focus {
        border-color: #6a11cb;
        box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.2);
    }

    .form-control, select {
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
        background: linear-gradient(to right, #5a0f9c, #7a36f0);
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
        <h2 class="text-center mb-4 text-purple fw-bold">Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-danger" />
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-danger" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-danger" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-danger" />
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="role">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                </select>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('login') }}" class="fade-link">Already registered?</a>

                <button type="submit" class="btn btn-purple">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
