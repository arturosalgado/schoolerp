<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        $logTypes = ['default', 'user', 'student', 'teacher', 'role', 'permission', 'program', 'system'];
        $levels = ['info', 'warning', 'error', 'success', 'debug'];
        $descriptions = [
            'created',
            'updated',
            'deleted',
            'restored',
            'logged in',
            'logged out',
            'password changed',
            'profile updated',
            'settings modified',
            'data exported',
            'report generated',
            'file uploaded',
            'email sent',
            'notification sent',
        ];

        $subjectTypes = [
            \App\Models\User::class,
            \App\Models\Student::class,
            \App\Models\Teacher::class,
            \App\Models\Role::class,
            \App\Models\Program::class,
        ];

        $subjectType = fake()->randomElement($subjectTypes);

        return [
            'log_name' => fake()->randomElement($logTypes),
            'description' => fake()->randomElement($descriptions),
            'subject_type' => $subjectType,
            'subject_id' => fake()->numberBetween(1, 1000),
            'causer_type' => User::class,
            'causer_id' => fake()->optional(0.8)->numberBetween(1, 100), // 80% have a user, 20% system
            'properties' => json_encode([
                'attributes' => [
                    'old' => fake()->words(3, true),
                    'new' => fake()->words(3, true),
                ],
                'ip' => fake()->ipv4(),
                'user_agent' => fake()->userAgent(),
            ]),
            'school_id' => fake()->numberBetween(1, 10),
            'level' => fake()->randomElement($levels),
            'created_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
        ];
    }
}
