<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;

class CleanupActivityLog extends Command
{
    protected $signature = 'activitylog:cleanup
                            {--days=90 : Delete logs older than X days}
                            {--dry-run : Show what would be deleted without actually deleting}';

    protected $description = 'Clean up old activity logs';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $dryRun = $this->option('dry-run');

        $date = now()->subDays($days);

        $query = Activity::where('created_at', '<', $date);
        $count = $query->count();

        if ($count === 0) {
            $this->info("No activity logs older than {$days} days found.");
            return Command::SUCCESS;
        }

        if ($dryRun) {
            $this->info("DRY RUN: Would delete {$count} activity logs older than {$days} days (before {$date->format('Y-m-d')})");

            // Show breakdown by log type
            $breakdown = Activity::where('created_at', '<', $date)
                ->selectRaw('log_name, count(*) as count')
                ->groupBy('log_name')
                ->get();

            $this->newLine();
            $this->info('Breakdown by log type:');
            foreach ($breakdown as $item) {
                $this->line("  {$item->log_name}: {$item->count}");
            }

            return Command::SUCCESS;
        }

        if (!$this->confirm("Delete {$count} activity logs older than {$days} days?", false)) {
            $this->info('Cleanup cancelled.');
            return Command::SUCCESS;
        }

        $this->info("Deleting old activity logs...");

        // Delete in chunks to avoid memory issues
        $deleted = 0;
        $chunkSize = 1000;

        while (true) {
            $chunkDeleted = Activity::where('created_at', '<', $date)
                ->limit($chunkSize)
                ->delete();

            $deleted += $chunkDeleted;

            if ($chunkDeleted < $chunkSize) {
                break;
            }

            $this->info("Deleted {$deleted} records so far...");
        }

        $this->info("Successfully deleted {$deleted} activity logs!");

        return Command::SUCCESS;
    }
}
