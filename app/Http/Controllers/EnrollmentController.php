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
        // Fetch all enrollments with their related student and subjects
        $enrollments = Enrollment::with(['student', 'subjects'])->get();

        // Fetch all students and subjects
        $students = Student::all();
        $subjects = Subject::all();

        // Pass the data to the view
        return view('admin.enrollments.index', compact('enrollments', 'students', 'subjects'));
    }


    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'student_select' => 'required|exists:students,id', // Ensure student exists
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'course' => 'required|string',
            'year_level' => 'required|integer',
            'subject_id' => 'required|array',
            'subject_id.*' => 'exists:subjects,id',
            'email' => 'required|email',
        ]);

        // Retrieve the student record using the selected student's ID
        $student = Student::findOrFail($request->student_select);

        // Create the enrollment using the actual student_id
        $enrollment = Enrollment::create([
            'student_id' => $student->id, // Store actual student number
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

}
