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
            $table->string('adm_no')->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedTinyInteger('graduation_status')->default(0);
            $table->string('dorm_room')->nullable();
            $table->date('year_admitted')->nullable();
            $table->date('graduation_date')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('password');

            $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->onDelete('set null');
            $table->foreignId('dorm_id')->nullable()->constrained('dorms')->onDelete('set null');
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
