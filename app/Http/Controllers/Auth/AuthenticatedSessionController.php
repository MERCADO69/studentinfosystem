<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        // Determine the guard from the request (e.g., from a hidden input in the form)
        $guard = $request->input('guard', 'web');

        // Attempt to authenticate the user
        if (!Auth::guard($guard)->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect based on the guard
        return redirect()->intended(
            $guard === 'student' ? route('student.dashboard') : route('admin.dashboard')
        );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Determine the guard (e.g., from the authenticated user)
        $guard = Auth::guard('student')->check() ? 'student' : 'web';

        // Logout the user
        Auth::guard($guard)->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect('/login');
    }
}
