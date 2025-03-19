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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->nullable();
            $table->string('school_acronym')->nullable();
            $table->string('school_address')->nullable();
            $table->string('school_phone_number')->nullable();
            $table->string('school_phone_other')->nullable();
            $table->string('school_email')->nullable();
            $table->unsignedSmallInteger('current_year')->nullable();
            $table->unsignedTinyInteger('current_term')->nullable();
            $table->date('term_begins')->nullable();
            $table->date('term_ends')->nullable();
            $table->string('bursar_stamp')->nullable();
            $table->string('principal_stamp')->nullable();
            $table->string('storekeeper_stamp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
