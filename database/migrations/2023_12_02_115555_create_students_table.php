<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->string('course');
            $table->string('year');
            // $table->string('email');
            $table->unsignedBigInteger('class_schedule_id');
            $table->string('gender');
            // $table->unsignedBigInteger('class_schedule_id')->nullable()->collation('utf8mb4_unicode_ci');
            // $table->foreign('class_schedule_id')->references('id')->on('class_schedules')->collation('utf8mb4_unicode_ci');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
