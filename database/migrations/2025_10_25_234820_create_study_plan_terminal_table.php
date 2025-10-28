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
        Schema::create('study_plan_terminal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_plan_id');
            $table->unsignedBigInteger('terminal_id');
            $table->timestamps();

            $table->foreign('study_plan_id')->references('id')->on('study_plans')->onDelete('cascade');
            $table->foreign('terminal_id')->references('id')->on('terminals')->onDelete('cascade');

            $table->unique(['study_plan_id', 'terminal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_plan_terminal');
    }
};
