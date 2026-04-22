<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollment_period_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_period_id')->constrained('enrollment_periods')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->unsignedInteger('quota')->nullable();
            $table->timestamps();

            $table->unique(['enrollment_period_id', 'program_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment_period_program');
    }
};
