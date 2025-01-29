<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Update the last_logged_in_at timestamp when the user logs in
        $user = Auth::user();
        $user->update(['last_logged_in_at' => now()]);

        \Log::info('User logged in and last_logged_in_at updated:', [
            'user_id' => $user->id,
            'last_logged_in_at' => $user->last_logged_in_at,
        ]);

        $request->session()->regenerate();

        // Redirect based on user role
        if ($user->role === 'student') {
            return redirect()->route('dashboard'); // Redirect students to the list of all students
        } elseif ($user->role === 'teacher') {
            return redirect()->route('teacher.dashboard'); // Redirect teachers to their dashboard
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
