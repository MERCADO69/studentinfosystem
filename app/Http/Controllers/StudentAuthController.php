<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class StudentAuthController extends Controller
{
    /**
     * Display the student login form.
     */
    public function showLoginForm()
    {
        return view('student.auth.login');
    }

    /**
     * Handle an incoming student authentication request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Use the 'student' guard for authentication
        if (Auth::guard('student')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('student.dashboard');
        }

        // If authentication fails, return with an error
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Log out the student.
     */
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login');
    }
}
