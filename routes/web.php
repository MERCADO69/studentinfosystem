<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\admin\GradeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentGradesController;

Route::get('/', function () {
    return redirect('/login'); // Redirect to the login page
});
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->role === 'student') {
        return redirect()->route('student.dashboard');
    }
    return abort(403);
    // If role is somehow not set, prevent access
})->name('dashboard');



// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Dashboard & modules
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/enrollments', [AdminController::class, 'enrollments'])->name('admin.enrollments.index');
    Route::get('/admin/grades', [AdminController::class, 'grades'])->name('admin.grades.index');
    Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students.index');
    Route::get('/admin/students/add', [AdminController::class, 'addStudent'])->name('admin.students.add');
    Route::post('/admin/students/add', [StudentController::class, 'store'])->name('admin.students.addstudents');
    Route::get('/admin/grades', [GradeController::class, 'index'])->name('admin.grades.index');
    Route::get('/admin/students/list', [StudentController::class, 'list'])->name('admin.students.list');
    Route::put('/admin/students/{id}', [StudentController::class, 'update'])->name('admin.students.update');
    Route::get('/admin/students/{id}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::get('/students/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
    Route::post('/admin/enrollments/store', [EnrollmentController::class, 'store'])->name('admin.enrollments.store');
    Route::post('/admin/enrollments', [EnrollmentController::class, 'store'])->name('admin.enrollments.store');
    Route::post('/admin/enrollments', [EnrollmentController::class, 'store'])->name('admin.enrollments.store');
    Route::delete('/admin/students/{id}', [StudentController::class, 'destroy'])->name('admin.students.destroy');


    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::resource('students', StudentController::class)->names([
            'index' => 'admin.students.list',
            'create' => 'admin.students.create',
            'store' => 'admin.students.store',
            'edit' => 'admin.students.edit',
            'update' => 'admin.students.update',
            'destroy' => 'admin.students.destroy',
        ]);
    });


    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');

    // Use SubjectController for Subject Management inside Admin
    Route::prefix('admin')->group(function () {
        // Subjects Routes
        Route::get('/subjects', [SubjectController::class, 'index'])->name('admin.subjects.index');
        Route::post('/subjects', [SubjectController::class, 'store'])->name('admin.subjects.store');
        Route::get('/subjects/{id}/edit', [SubjectController::class, 'edit'])->name('admin.subjects.edit');
        Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('admin.subjects.update');
        Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('admin.subjects.destroy');

        // Students Routes
        Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
        Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
        Route::get('/admin/students/add', [AdminController::class, 'addStudent'])->name('admin.students.add');
        Route::get('/students/create', [StudentController::class, 'create'])->name('admin.students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');


        // Enrollments Routes
        Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('admin.enrollments.index');
        Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('admin.enrollments.store');
        Route::get('/enrollments/{id}/edit', [EnrollmentController::class, 'edit'])->name('admin.enrollments.edit');
        Route::put('/enrollments/{id}', [EnrollmentController::class, 'update'])->name('admin.enrollments.update');
        Route::delete('/enrollments/{id}', [EnrollmentController::class, 'destroy'])->name('admin.enrollments.destroy');
        Route::get('/admin/students', [EnrollmentController::class, 'studentsIndex'])->name('admin.students.index');
        Route::post('/admin/enrollments/store', [EnrollmentController::class, 'store'])->name('admin.enrollments.store');

        // Grade Routes
        Route::get('grades/create', [GradeController::class, 'create'])->name('admin.grades.create');
        Route::post('grades', [GradeController::class, 'store'])->name('admin.grades.store');
        Route::get('grades/edit/{student_id}', [GradeController::class, 'edit'])->name('admin.grades.edit');
        Route::put('grades/{id}', [GradeController::class, 'update'])->name('admin.grades.update');
        Route::delete('grades/{id}', [GradeController::class, 'destroy'])->name('admin.grades.destroy');
        Route::get('grades/view/{student_id}', [GradeController::class, 'view'])->name('admin.grades.view');
        Route::get('get-student-subjects/{student_id}', [GradeController::class, 'getStudentSubjects']);
    }); // **Closing for Route::prefix('admin')** ✅

}); // **Closing for Route::middleware(['auth', 'admin'])** ✅



// Student Dashboard & Modules
Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'Dashboard'])->name('student.dashboard');
    Route::get('/student/grades', [StudentGradesController::class, 'index'])->name('student.grades.index');

});



require __DIR__ . '/auth.php';

