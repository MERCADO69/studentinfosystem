<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str; // ✅ For random password generator

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'student_id' => ['required', 'unique:students,student_id'],
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'course' => ['required', 'string'],
            'year_level' => ['required', 'integer'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students,email'],
        ]);

        // ✅ Generate a RANDOM 8-character password
        $randomPassword = Str::random(8); // This generates 8 random characters

        // ✅ Step 1: Create the Student First
        $student = Student::create([
            'student_id' => $request->student_id,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'email' => $request->email,
        ]);

        // ✅ Step 2: Create the User Using student_id as Foreign Key
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($randomPassword), // ✅ Use the randomized password
            'student_id' => $student->student_id,
            'role' => 'student',
        ]);

        // ✅ Step 3: Send the email with the password
        $user->notify(new \App\Notifications\PasswordNotification($randomPassword));

        // ✅ Step 4: Fire the registration event
        event(new Registered($user));

        // ✅ Step 5: Auto-login the user
        Auth::login($user);

        // ✅ Step 6: Redirect to dashboard
        return redirect(route('dashboard'))->with('success', 'Account successfully registered. Check your email for the password!');
    }
}
