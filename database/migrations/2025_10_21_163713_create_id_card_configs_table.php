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
        Schema::create('id_card_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('name')->nullable();
            $table->string('front_path')->nullable();
            $table->string('back_path')->nullable();
            $table->integer('photo_x')->default(0);
            $table->integer('photo_y')->default(0);
            $table->integer('photo_width')->default(150);
            $table->integer('photo_height')->default(200);
            $table->integer('name_x')->default(50);
            $table->integer('name_y')->default(100);
            $table->integer('enrollment_x')->default(50);
            $table->integer('enrollment_y')->default(130);
            $table->integer('career_x')->default(50);
            $table->integer('career_y')->default(160);
            $table->integer('back_top')->default(300);
            $table->string('color')->nullable();
            $table->string('font')->nullable();
            $table->string('size')->nullable();
            $table->boolean('showEnrollment')->default(true);
            $table->boolean('showProgram')->default(true);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id_card_configs');
    }
};
