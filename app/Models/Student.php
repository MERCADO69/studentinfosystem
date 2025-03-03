<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Change from Model to Authenticatable
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable // Extend Authenticatable instead of Model
{
    use HasFactory, Notifiable;

    // Fields that can be mass-assigned
    protected $fillable = [
        'student_id',
        'last_name',
        'first_name',
        'course',
        'year_level',
        'email',
        'password', // ✅ Add password for authentication
    ];

    // Hide password from JSON responses
    protected $hidden = [
        'password',
    ];

    // Relationship: Student has many enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id', 'student_id');
    }
}
