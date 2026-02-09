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
        Schema::table('role_user', function (Blueprint $table) {
            $table->foreignId('school_id')->nullable()->after('user_id')->constrained('schools')->onDelete('cascade');
            $table->index('school_id');
        });



        Schema::table('role_user', function (Blueprint $table) {
            // Update unique constraint to include school_id

            $table->unique(['role_id', 'user_id', 'school_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropUnique(['role_id', 'user_id', 'school_id']);

            $table->dropForeign(['school_id']);
            $table->dropColumn('school_id');
        });
    }
};
