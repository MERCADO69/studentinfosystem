<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('enrollment_subject', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('enrollment_id');
        $table->unsignedBigInteger('subject_id');
        $table->string('grade')->nullable(); // Add this line
        $table->string('remarks')->nullable(); // Add this line
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('enrollment_id')->references('id')->on('enrollments')->onDelete('cascade');
        $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::dropIfExists('enrollment_subject');
    }
};
