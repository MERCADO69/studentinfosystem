<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'student_id',
        'last_name',
        'first_name',
        'course',
        'year_level',
        'email', // Add this line
        'user_id', // Add this line if you want to link the student to a user
    ];

    // Relationship: Student belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // FIX: Use student_id as the foreign key in enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id', 'student_id');
    }
}
