<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Get all students and shuffle to ensure uniqueness
        $students = Student::select('student_id', 'first_name', 'last_name', 'email')->get();

        foreach ($students as $student) {
            User::factory()->create([
                'student_id' => $student->student_id,
                'name' => $student->first_name . ' ' . $student->last_name, // Combine first and last name
                'email' => $student->email,
            ]);
        }
    }
}
