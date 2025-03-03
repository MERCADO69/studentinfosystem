<?php

// app/Http/Controllers/Admin/GradeController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{

    public function index()
    {
        $enrollments = Enrollment::with(['subjects', 'grades.subject', 'student'])->get();

        // Debugging: Log or Dump the Data
        \Log::info($enrollments->toArray()); // Check Laravel logs
        dd($enrollments); // Stop execution & dump data

        return view('admin.grades.index', compact('enrollments'));
    }

    // Show form to add grade
    public function create()
    {
        $enrollments = Enrollment::all();
        $subjects = Subject::all();
        return view('admin.grades.create', compact('enrollments', 'subjects'));
    }

    // Store the grade
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:enrollments,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:1.00|max:5.00',
        ]);

        // Create or update the grade
        Grade::updateOrCreate(
            ['student_id' => $request->student_id, 'subject_id' => $request->subject_id],
            ['grade' => $request->grade]
        );

        return redirect()->route('admin.students.index')
            ->with('success', 'Grade added successfully');
    }

    // Show the edit grade form
    public function edit($student_id)
    {
        $student = Enrollment::findOrFail($student_id);
        $enrolledSubjects = $student->subjects;
        $grades = Grade::where('student_id', $student->id)->with('subject')->get();


        return view('admin.grades.edit', compact('student', 'enrolledSubjects', 'grades'));
    }

    // Update the grade
    public function update(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|numeric|min:1.00|max:5.00',
        ]);

        $grade = Grade::findOrFail($id);
        $grade->update(['grade' => $request->grade]);

        return redirect()->route('admin.grades.edit', $grade->student_id)
            ->with('success', 'Grade updated successfully');
    }

    // Delete a grade
    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $student_id = $grade->student_id;
        $grade->delete();

        return redirect()->route('admin.grades.edit', $student_id)
            ->with('success', 'Grade deleted successfully');
    }

    // View student's grades
    public function view($student_id)
    {
        $student = Enrollment::findOrFail($student_id);
        $grades = Grade::where('student_id', $student_id)->get();

        return view('admin.grades.view', compact('student', 'grades'));
    }

    // Get enrolled subjects for a student (for AJAX)
    public function getStudentSubjects($student_id)
    {
        $student = Enrollment::findOrFail($student_id);
        $subjects = $student->subjects;

        return response()->json(['subjects' => $subjects]);
    }
}