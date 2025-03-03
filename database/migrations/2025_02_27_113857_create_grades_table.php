<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id');
            // Fix for the float parameters - use decimal instead with precision and scale
            $table->decimal('grade', 5, 2); // 5 total digits, 2 after decimal point
            $table->timestamps();

            // Composite unique key to prevent duplicate grades for the same student-subject pair
            $table->unique(['student_id', 'subject_id']);

            // Foreign keys
            $table->foreign('student_id')->references('id')->on('enrollments')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
};
