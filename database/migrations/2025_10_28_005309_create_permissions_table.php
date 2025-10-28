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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('resource');
            $table->string('action');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->string('panel')->nullable();
            $table->string('name')->virtualAs("concat_ws('.', panel, resource, action)");
            $table->string('resource_es')->nullable();

            // Indexes
            $table->unique(['panel', 'resource', 'action']);
            $table->index(['resource', 'action']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
