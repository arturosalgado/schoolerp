<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class ActivityLogSeeder extends Seeder
{
    /**
     * Seed the activity log table with millions of records.
     *
     * Usage:
     * - php artisan db:seed --class=ActivityLogSeeder
     * - Or with custom count: php artisan tinker then ActivityLogSeeder::seedRecords(1000000)
     */
    public function run(): void
    {
        $this->command->info('Starting activity log seeding...');

        // Generate 100,000 records by default (adjust as needed)
        $totalRecords = 100000;
        $this->seedRecords($totalRecords);

        $this->command->info("Successfully seeded {$totalRecords} activity log records!");
    }

    /**
     * Seed a specific number of records efficiently using chunks.
     *
     * @param int $totalRecords Total number of records to create
     * @param int $chunkSize Number of records to insert per batch
     */
    public static function seedRecords(int $totalRecords, int $chunkSize = 1000): void
    {
        echo "Seeding {$totalRecords} activity log records in chunks of {$chunkSize}...\n";

        $logTypes = ['default', 'user', 'student', 'teacher', 'role', 'permission', 'program', 'system'];
        $levels = ['info', 'warning', 'error', 'success', 'debug'];
        $descriptions = [
            'created', 'updated', 'deleted', 'restored', 'logged in', 'logged out',
            'password changed', 'profile updated', 'settings modified', 'data exported',
            'report generated', 'file uploaded', 'email sent', 'notification sent',
        ];
        $subjectTypes = [
            'App\\Models\\User',
            'App\\Models\\Student',
            'App\\Models\\Teacher',
            'App\\Models\\Role',
            'App\\Models\\Program',
        ];

        $chunks = ceil($totalRecords / $chunkSize);
        $startTime = microtime(true);

        for ($chunk = 0; $chunk < $chunks; $chunk++) {
            $records = [];
            $recordsInThisChunk = min($chunkSize, $totalRecords - ($chunk * $chunkSize));

            for ($i = 0; $i < $recordsInThisChunk; $i++) {
                $createdAt = now()->subDays(rand(0, 730))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

                $records[] = [
                    'log_name' => $logTypes[array_rand($logTypes)],
                    'description' => $descriptions[array_rand($descriptions)],
                    'subject_type' => $subjectTypes[array_rand($subjectTypes)],
                    'subject_id' => rand(1, 1000),
                    'causer_type' => rand(0, 9) < 8 ? 'App\\Models\\User' : null, // 80% have user
                    'causer_id' => rand(0, 9) < 8 ? rand(1, 100) : null,
                    'properties' => json_encode([
                        'attributes' => ['old' => 'value_' . rand(1, 100), 'new' => 'value_' . rand(1, 100)],
                        'ip' => long2ip(rand(0, 4294967295)),
                    ]),
                    'school_id' => rand(1, 10),
                    'level' => $levels[array_rand($levels)],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }

            DB::table('activity_log')->insert($records);

            $processed = ($chunk + 1) * $chunkSize;
            if ($processed > $totalRecords) $processed = $totalRecords;

            $elapsed = round(microtime(true) - $startTime, 2);
            $rate = round($processed / $elapsed, 0);
            echo "Progress: {$processed}/{$totalRecords} ({$rate} records/sec)\n";
        }

        $totalTime = round(microtime(true) - $startTime, 2);
        echo "Completed in {$totalTime} seconds!\n";
    }
}
