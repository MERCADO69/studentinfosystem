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

            // Restrict grades using ENUM
            $table->enum('grade', ['1.00', '1.25', '1.50', '1.75', '2.00', '2.25', '2.50', '2.75', '3.00', '5.00']);

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