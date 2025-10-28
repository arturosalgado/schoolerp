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
        Schema::create('panel_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panel_id')->constrained('panels')->onDelete('cascade')->onUpdate('restrict');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade')->onUpdate('restrict');
            $table->timestamps();
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade')->onUpdate('restrict');

            $table->unique(['panel_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panel_role');
    }
};
