<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Hash;
use App\Models\Subject;
use App\Models\User;
use App\Models\Student;
use App\Models\Grade;
class EnrollmentController extends Controller
{
    // Display the list of enrolled students
    public function index()
    {
        $students = Student::all();
        $users = User::whereNotNull('student_id')->get(); // Fetch users who were students
        $subjects = Subject::all();
        $enrollments = Enrollment::all();

        return view('admin.enrollments.index', compact('students', 'users', 'subjects', 'enrollments'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'student_select' => 'required',
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'course' => 'required|string',
            'year_level' => 'required|integer',
            'subject_id' => 'required|array',
            'subject_id.*' => 'exists:subjects,id',
            'email' => 'required|email',
        ]);

        // Check if the selected student is from `users` or `students`
        $student = Student::find($request->student_select);
        if (!$student) {
            $user = User::where('student_id', $request->student_select)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'Selected student not found.');
            }
            $student_id = $user->student_id; // Use student_id from users table
        } else {
            $student_id = $student->student_id;
        }

        // Check if the student is already enrolled
        if (Enrollment::where('student_id', $student_id)->exists()) {
            return redirect()->back()->with('error', 'Student is already enrolled.');
        }

        // Store the enrollment
        $enrollment = Enrollment::create([
            'student_id' => $student_id,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'email' => $request->email,
        ]);

        // Attach selected subjects to the enrollment
        $enrollment->subjects()->attach($request->subject_id);

        return redirect()->route('admin.enrollments.index')->with('success', 'Student successfully enrolled!');
    }

    // Edit student enrollment details
    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $subjects = Subject::all();
        return view('admin.enrollments.edit', compact('enrollment', 'subjects'));
    }

    // Update enrollment details
    public function update(Request $request, $id)
    {
        // Find the enrollment
        $enrollment = Enrollment::findOrFail($id);

        // Validate the request
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'year_level' => 'required|integer|between:1,4',
            'subject_id' => 'required|array', // Ensure at least one subject is selected
            'subject_id.*' => 'exists:subjects,id', // Ensure each subject exists
            'email' => 'required|email|unique:enrollments,email,' . $id,
        ]);

        // Update enrollment details
        $enrollment->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'email' => $request->email,
        ]);

        // Update the student's details
        if ($enrollment->student) {
            $enrollment->student->update([
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'course' => $request->course,
                'year_level' => $request->year_level,
                'email' => $request->email,
            ]);
        }

        // Update the user's details if a linked account exists
        if ($enrollment->student && $enrollment->student->user) {
            $enrollment->student->user->update([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
            ]);
        }

        // Sync subjects in the pivot table
        $enrollment->subjects()->sync($request->subject_id);

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment updated successfully!');
    }


    // Delete enrollment
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);

        // Delete the enrollment record
        $enrollment->delete();

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment deleted successfully');
    }


    public function studentsIndex()
    {
        // Retrieve all enrollments
        $enrollments = Enrollment::with('subjects')->get();

        // Pass enrollments to the students view
        return view('admin.students.index', compact('enrollments'));
    }
    public function getSubjects($id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json(['error' => 'Enrollment not found'], 404);
        }

        return response()->json(['subjects' => $enrollment->subjects]);
    }

}