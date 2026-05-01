<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prospects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('enrollment_period_id')->nullable()->constrained('enrollment_periods')->onDelete('set null');
            $table->string('name');
            $table->string('last_name');
            $table->string('second_last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->date('dob')->nullable();
            $table->string('sex')->nullable();
            $table->string('curp')->nullable();
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('set null');
            $table->string('photo')->nullable();
            $table->string('source')->nullable(); // e.g. referral, social media, website
            $table->string('status')->default('new'); // new, contacted, interested, converted, lost
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prospects');
    }
};
