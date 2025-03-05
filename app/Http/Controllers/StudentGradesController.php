<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;

class StudentGradesController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Ensure the user has a student_id
        if (!$user->student_id) {
            return back()->with('error', 'No student record found.');
        }

        // Get all enrollments for the logged-in student, along with subjects and grades
        $enrollments = Enrollment::where('student_id', $user->student_id)
            ->with(['subjects', 'grades'])  // Eager load subjects and grades
            ->get();

        // Initialize an empty collection to store the grades
        $grades = collect();

        // Loop through enrollments and subjects
        foreach ($enrollments as $enrollment) {
            foreach ($enrollment->subjects as $subject) {
                // Find the grade for the subject
                $gradeEntry = $enrollment->grades->where('subject_id', $subject->id)->first();

                // Add the grade and remarks, or set defaults if not available
                $grades->push([
                    'subject_name' => $subject->subject_name,
                    'subject_code' => $subject->subject_code,
                    'units' => $subject->units,
                    'grade' => $gradeEntry ? $gradeEntry->grade : null,  // Use null if no grade
                    'remarks' => $gradeEntry ? ($gradeEntry->grade == 5.00 ? 'Failed' : 'Passed') : 'No Grade',  // Adjust remarks logic
                ]);
            }
        }

        // Return the grades view with the grades data
        return view('student.grades.index', compact('grades'));
    }

}