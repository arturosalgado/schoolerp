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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('second_last_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('password');
            $table->string('picture')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            // Virtual generated column for full_name
            // Concatenates last_name, second_last_name (if not empty), and name with spaces
            $table->string('full_name')
                ->virtualAs("CONCAT_WS(' ', last_name, NULLIF(second_last_name, ''), name)");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
