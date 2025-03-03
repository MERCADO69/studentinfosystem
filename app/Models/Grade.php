<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'student_id', // Add this line
        'enrollment_id',
        'subject_id',
        'grade',
    ];

    // Relationship: Grade belongs to a Subject
    public function subject()
{
    return $this->belongsTo(Subject::class, 'subject_id', 'id');
}
    // Relationship: Grade belongs to an Enrollment
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }
}

