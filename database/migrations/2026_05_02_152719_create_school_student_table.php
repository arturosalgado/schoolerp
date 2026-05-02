<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_student', function (Blueprint $table) {
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('student_status_id')->constrained('student_statuses');
            $table->string('enrollment')->nullable();
            $table->primary(['school_id', 'student_id']);
            $table->unique(['school_id', 'enrollment']);
            $table->timestamps();
        });

        

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['student_status_id']);
            $table->dropColumn(['school_id', 'student_status_id']);
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('school_id')->nullable()->constrained('schools');
            $table->foreignId('student_status_id')->nullable()->constrained('student_statuses');
        });

        Schema::dropIfExists('school_student');
    }
};
