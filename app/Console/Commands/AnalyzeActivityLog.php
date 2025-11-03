<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class AnalyzeActivityLog extends Command
{
    protected $signature = 'activitylog:analyze';
    protected $description = 'Analyze activity log table size and performance';

    public function handle(): int
    {
        $this->info('📊 Activity Log Analysis');
        $this->newLine();

        // Count records
        $totalRecords = Activity::count();
        $this->info("Total Records: " . number_format($totalRecords));

        // Table size
        $tableSize = DB::select("
            SELECT
                table_name AS 'Table',
                ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)',
                ROUND((data_length / 1024 / 1024), 2) AS 'Data (MB)',
                ROUND((index_length / 1024 / 1024), 2) AS 'Index (MB)',
                table_rows AS 'Rows'
            FROM information_schema.TABLES
            WHERE table_schema = DATABASE()
            AND table_name = 'activity_log'
        ");

        if (!empty($tableSize)) {
            $size = $tableSize[0];
            $this->info("Table Size: {$size->{'Size (MB)'}} MB");
            $this->info("Data Size: {$size->{'Data (MB)'}} MB");
            $this->info("Index Size: {$size->{'Index (MB)'}} MB");
        }

        $this->newLine();

        // Records by date range
        $this->info('📅 Records by Time Period:');
        $last24h = Activity::where('created_at', '>=', now()->subDay())->count();
        $last7d = Activity::where('created_at', '>=', now()->subWeek())->count();
        $last30d = Activity::where('created_at', '>=', now()->subMonth())->count();
        $last90d = Activity::where('created_at', '>=', now()->subMonths(3))->count();

        $this->info("Last 24 hours: " . number_format($last24h));
        $this->info("Last 7 days: " . number_format($last7d));
        $this->info("Last 30 days: " . number_format($last30d));
        $this->info("Last 90 days: " . number_format($last90d));

        $this->newLine();

        // Average per day
        if ($totalRecords > 0) {
            $oldestRecord = Activity::orderBy('created_at')->first();
            if ($oldestRecord) {
                $daysSinceOldest = now()->diffInDays($oldestRecord->created_at);
                if ($daysSinceOldest > 0) {
                    $avgPerDay = round($totalRecords / $daysSinceOldest, 0);
                    $this->info("Average per day: " . number_format($avgPerDay));

                    // Projections
                    $this->newLine();
                    $this->info('📈 Growth Projections (based on current rate):');
                    $this->info("1 year: " . number_format($avgPerDay * 365) . " records");
                    $this->info("2 years: " . number_format($avgPerDay * 730) . " records");

                    if (!empty($tableSize)) {
                        $sizePerRecord = $size->{'Size (MB)'} / $totalRecords;
                        $projectedSize1Year = round($sizePerRecord * $avgPerDay * 365, 2);
                        $projectedSize2Years = round($sizePerRecord * $avgPerDay * 730, 2);
                        $this->info("Projected size in 1 year: {$projectedSize1Year} MB");
                        $this->info("Projected size in 2 years: {$projectedSize2Years} MB");
                    }
                }
            }
        }

        $this->newLine();

        // Top log types
        $this->info('📋 Top Log Types:');
        $topLogs = Activity::select('log_name', DB::raw('count(*) as count'))
            ->groupBy('log_name')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        foreach ($topLogs as $log) {
            $this->info("  {$log->log_name}: " . number_format($log->count));
        }

        $this->newLine();

        // Performance recommendations
        $this->info('💡 Recommendations:');
        if ($totalRecords > 1000000) {
            $this->warn('⚠ You have over 1 million records. Consider:');
            $this->line('  - Implementing automatic cleanup for old records');
            $this->line('  - Archiving logs older than 6-12 months');
            $this->line('  - Using partitioning for better performance');
        } elseif ($totalRecords > 100000) {
            $this->comment('✓ Table size is moderate. Monitor growth and plan cleanup strategy.');
        } else {
            $this->info('✓ Table size is healthy. No immediate action needed.');
        }

        return Command::SUCCESS;
    }
}
