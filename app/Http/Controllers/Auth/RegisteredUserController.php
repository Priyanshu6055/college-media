<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register'); // Return the register view with the role selection form
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming registration request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,teacher'], // Validate the role field
        ]);

        // Create the user with the role selected by the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Store the role in the database
        ]);

        // Fire the Registered event and log the user in
        event(new Registered($user));

        // Log the user in automatically
        Auth::login($user);

        // Redirect based on the user's role
        if ($user->role == 'student') {
            // Redirect students to the list of all students after registration
            return redirect()->route('dashboard'); 
        } elseif ($user->role == 'teacher') {
            // Redirect teachers to their dashboard after registration
            return redirect()->route('teacher.dashboard');
        }

        // Default redirect if role is not recognized
        return redirect(RouteServiceProvider::HOME);
    }
}
