<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard'); // Ensure this view exists
    }
    public function students()
    {
        return view('admin.students.index');
    }
    public function subjects()
    {
        return view('admin.subjects.index');
    }
    public function enrollments()
    {
        return view('admin.enrollments.index');
    }
    public function grades()
    {
        return view('admin.grades.index');
    }
    public function addStudent()
    {
    return view('admin.students.addstudent'); // Load addstudent.blade.php
    }


}
