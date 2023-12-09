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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('course');
            $table->string('year');
            $table->string('timeIn');
            $table->string('timeOut');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_schedule_id');
            $table->unsignedBigInteger('event_id'); // New foreign key for events table
            $table->timestamps();

        });       
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
