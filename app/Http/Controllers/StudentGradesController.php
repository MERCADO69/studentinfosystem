<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;

class StudentGradesController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        if (!$user->student) {
            return back()->with('error', 'No student record found.');
        }

        // Get all enrollments for the logged-in student, along with subjects and grades
        $enrollments = Enrollment::where('student_id', $user->student_id) // Use student_id properly
            ->with(['subjects', 'grades'])
            ->get();

        // Transform data to match Blade structure
        $grades = collect(); // Empty collection

        foreach ($enrollments as $enrollment) {
            foreach ($enrollment->subjects as $subject) {
                $gradeEntry = $enrollment->grades->where('subject_id', $subject->id)->first();

                $grades->push([
                    'subject_name' => $subject->subject_name,
                    'subject_code' => $subject->subject_code,
                    'units' => $subject->units,
                    'grade' => $gradeEntry->grade ?? 'No Grade',
                    'remarks' => $gradeEntry->remarks ?? 'No Remarks',
                ]);
            }
        }
        return view('student.grades.index', compact('grades'));
    }

}


