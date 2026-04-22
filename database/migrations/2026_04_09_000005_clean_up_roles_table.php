<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['hierarchy_level', 'level']);
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->integer('hierarchy_level')->default(0);
            $table->enum('level', ['student', 'admin', 'superadmin', 'teacher', 'academic', 'accountant'])->default('accountant');
        });
    }
};
