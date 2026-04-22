<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Permissions excluded from the admin role.
     */
    const ADMIN_EXCLUDED = [
        'schools.create',
        'schools.delete',
        'permissions.create',
        'permissions.update',
        'permissions.delete',
    ];

    /**
     * Permissions granted to teacher role.
     */
    const TEACHER_PERMISSIONS = [
        'students.viewAny',
        'students.view',
        'prospects.viewAny',
        'prospects.view',
        'enrollment-periods.viewAny',
        'enrollment-periods.view',
        'programs.viewAny',
        'programs.view',
        'cycles.viewAny',
        'cycles.view',
        'terms.viewAny',
        'terms.view',
        'study-plans.viewAny',
        'study-plans.view',
        'documents.viewAny',
        'documents.view',
    ];

    /**
     * Permissions granted to student role.
     */
    const STUDENT_PERMISSIONS = [
        'students.view',
    ];

    public function run(): void
    {
        $allPermissions = Permission::all();

        // super — everything
        $super = Role::where('name', 'super')->first();
        if ($super) {
            $this->syncPermissions($super, $allPermissions->pluck('name')->toArray());
        }

        // admin — everything except excluded
        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $adminPermissions = $allPermissions
                ->filter(fn($p) => !in_array($p->name, self::ADMIN_EXCLUDED))
                ->pluck('name')
                ->toArray();
            $this->syncPermissions($admin, $adminPermissions);
        }

        // teacher
        $teacher = Role::where('name', 'teacher')->first();
        if ($teacher) {
            $this->syncPermissions($teacher, self::TEACHER_PERMISSIONS);
        }

        // student
        $student = Role::where('name', 'student')->first();
        if ($student) {
            $this->syncPermissions($student, self::STUDENT_PERMISSIONS);
        }

        // prospect — no permissions
        // (intentionally left empty)
    }

    private function syncPermissions(Role $role, array $permissionNames): void
    {
        $ids = Permission::whereIn('name', $permissionNames)
            ->pluck('id')
            ->mapWithKeys(fn($id) => [$id => ['active' => true]])
            ->toArray();

        $role->permissions()->sync($ids);
    }
}
