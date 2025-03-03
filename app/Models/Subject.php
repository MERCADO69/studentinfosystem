<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = ['subject_name', 'subject_code', 'units'];

    // Relationship: Subject belongs to many Enrollments (many-to-many)
    public function enrollments()
    {
        return $this->belongsToMany(Enrollment::class, 'enrollment_subject', 'subject_id', 'enrollment_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

}