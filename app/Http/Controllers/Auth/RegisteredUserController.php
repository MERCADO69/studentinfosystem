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

        // Step 1: Create the Student First
        $student = Student::create([
            'student_id' => $request->student_id,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'email' => $request->email,
        ]);

        // Step 2: Create the User Using student_id as Foreign Key
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make('12345678'), // Default Password
            'student_id' => $student->student_id, // Link via student_id
            'role' => 'student',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false))->with('success', 'Account successfully registered!');
    }
}