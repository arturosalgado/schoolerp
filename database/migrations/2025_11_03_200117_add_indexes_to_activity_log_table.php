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
        Schema::table('activity_log', function (Blueprint $table) {
            // Index for school filtering
            $table->index('school_id');

            // Index for level filtering
            $table->index('level');

            // Index for subject queries (type + id combination)
            $table->index(['subject_type', 'subject_id']);

            // Index for causer queries (type + id combination)
            $table->index(['causer_type', 'causer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropIndex(['school_id']);
            $table->dropIndex(['level']);
            $table->dropIndex(['subject_type', 'subject_id']);
            $table->dropIndex(['causer_type', 'causer_id']);
        });
    }
};
