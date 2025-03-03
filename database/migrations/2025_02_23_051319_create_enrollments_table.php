<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('student_id')->unique(); // Unique student ID
            $table->string('last_name');
            $table->string('first_name');
            $table->string('course');
            $table->integer('year_level'); // 1st to 4th year
            $table->string('email')->unique();
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
