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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('system')->default(false);
            $table->enum('level', ['student', 'admin', 'superadmin', 'teacher','academic','accountant'])->default('accountant');
            $table->text('description')->nullable();
            $table->integer('hierarchy_level')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unsignedBigInteger('school_id')->nullable();

            // Indexes
            $table->unique(['name', 'school_id']);
            $table->index('school_id');

            // Foreign keys
            $table->foreign('school_id')
                  ->references('id')
                  ->on('schools')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
