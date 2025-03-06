<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('student.dashboard');
    }
    public function index()
    {
        $student = Student::where('user_id', auth()->id())->first();
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['subjects', 'grades'])
            ->get();
        if ($enrollments->isEmpty()) {
            return view('student.grades.index', ['enrollments' => collect()]); // Empty collection
        }

        return view('student.grades.index', compact('enrollments'));
    }
    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();
        try {
            $student = Student::create([
                'student_id' => $validated['student_id'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'course' => $validated['course'],
                'year_level' => $validated['year_level'],
            ]);
            $password = $request->password ? bcrypt($request->password) : bcrypt('12345678');
            User::create([
                'student_id' => $student->student_id,
                'name' => $student->first_name . ' ' . $student->last_name,
                'email' => $student->email,
                'password' => $password,
            ]);

            return redirect()->back()->with('success', 'Student and user created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function create()
    {
        return view('admin.students.addstudent');
    }
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
    public function update(UpdateStudentRequest $request, $id)
    {
        $validated = $request->validated();
        $student = Student::findOrFail($id);
        $student->update([
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'course' => $validated['course'],
            'year_level' => $validated['year_level'],
            'email' => $validated['email'],
        ]);
        $user = User::where('student_id', $student->student_id)->first(); // Use `student_id` to find the user
        if ($user) {
            $user->update([
                'name' => $validated['last_name'] . ' ' . $validated['first_name'],
                'email' => $validated['email'],
            ]);
        }
        return redirect()->route('admin.students.list')->with('success', 'Student updated successfully');
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student) {
            $isEnrolled = Enrollment::where('student_id', $student->student_id)->exists();

            if ($isEnrolled) {
                return redirect()->route('admin.students.index')->with('error', 'Student cannot be deleted because they are enrolled in a subject.');
            } else {
                DB::transaction(function () use ($student) {
                    User::where('student_id', $student->student_id)->delete();
                    $student->delete();
                });
                return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
            }
        }

        return redirect()->route('admin.students.index')->with('error', 'Student not found.');
    }
}
