<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            // Drop old unique constraint that included panel
            $table->dropUnique(['panel', 'resource', 'action']);

            // Drop old virtual column (panel.resource.action)
            $table->dropColumn('name');
        });

        Schema::table('permissions', function (Blueprint $table) {
            // New virtual name is simply resource.action
            $table->string('name')->virtualAs("concat_ws('.', resource, action)")->after('action');

            // New unique constraint without panel
            $table->unique(['resource', 'action']);
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropUnique(['resource', 'action']);
            $table->dropColumn('name');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->string('name')->virtualAs("concat_ws('.', panel, resource, action)");
            $table->unique(['panel', 'resource', 'action']);
        });
    }
};
