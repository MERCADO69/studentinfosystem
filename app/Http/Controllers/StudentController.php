<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Enrollment;

class StudentController extends Controller
{
    // ✅ Student Dashboard
    public function dashboard()
    {
        return view('student.dashboard');
    }

    // ✅ Admin List of Students (Ensures proper relation with enrollments)
    public function index()
    {
        // Get the logged-in student
        $student = Student::where('user_id', auth()->id())->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        // Fetch enrollments with subjects and grades
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['subjects', 'grades'])
            ->get();

        // Debugging step
        if ($enrollments->isEmpty()) {
            return view('student.grades.index', ['enrollments' => collect()]); // Empty collection
        }

        return view('student.grades.index', compact('enrollments'));
    }


    // ✅ Store a new student (Handled by Admin)
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students,_id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'course' => 'required',
            'year_level' => 'required',
            'password' => 'required|min:6',
        ]);

        // Create student
        $student = Student::create([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'course' => $request->course,
            'year_level' => $request->year_level,
        ]);

        // Create user with the correct foreign key reference
        User::create([
            'student_id' => $student->student_id, // ✅ Use the auto-increment ID, not student_id
            'name' => $student->first_name . ' ' . $student->last_name,
            'email' => $student->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->back()->with('success', 'Student and user created successfully!');
    }

    // ✅ Create student form
    public function create()
    {
        return view('admin.students.addstudent');
    }

    // ✅ Student Grades Page
    public function grades()
    {
        return view('student.grades.index');
    }

    public function list()
    {
        $students = Student::all();
        return view('admin.students.listofstudent', compact('students'));
    }
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'year_level' => 'required|integer|min:1|max:4',
            'email' => 'required|email|max:255',
        ]);

        // Find the student
        $student = Student::findOrFail($id);
        $student->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'email' => $request->email,
        ]);

        // Find the associated user and update their information
        if ($student->user_id) {
            $user = User::find($student->user_id);
            if ($user) {
                $user->update([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                ]);
            }
        }

        return redirect()->route('admin.students.list')->with('success', 'Student updated successfully');
    }


    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Delete the associated user if exists
        if ($student->user_id) {
            $user = User::find($student->user_id);
            if ($user) {
                $user->delete(); // Delete the user from the users table
            }
        }

        // Delete the student record
        $student->delete();

        return redirect()->route('admin.students.list')->with('success', 'Student deleted successfully');
    }


}
