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
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('second_last_name')->nullable();
            $table->string('enrollment')->unique()->nullable();
            $table->string('photo')->nullable();
            $table->date('dob')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->string('curp', 18)->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile')->nullable();
            $table->string('notes')->nullable();
            $table->foreignId('student_status_id')->nullable()->constrained('student_statuses');
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('state_id')->nullable()->constrained('states');
            $table->timestamps();
            $table->softDeletes();
            $table->string('full_name')->nullable()->virtualAs('CONCAT(name, " ", COALESCE(last_name, ""), " ", COALESCE(second_last_name, ""))');
            $table->string('extra_field_1')->nullable();
            $table->string('extra_field_2')->nullable();
            $table->string('extra_field_3')->nullable();
            $table->string('extra_field_4')->nullable();
            $table->string('extra_field_5')->nullable();
            $table->foreignId('blood_type_id')->nullable()->constrained('blood_types');
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_name')->nullable();
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
