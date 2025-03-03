<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'student_id', // Ensure this matches the students table
        'last_name',
        'first_name',
        'course',
        'year_level',
        'email',
    ];

    // Relationship: Enrollment belongs to a Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    // Relationship: Enrollment has many Subjects (many-to-many)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollment_subject', 'enrollment_id', 'subject_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id', 'id');
    }

}
