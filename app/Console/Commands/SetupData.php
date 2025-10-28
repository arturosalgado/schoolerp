<?php

namespace App\Console\Commands;

use App\Actions\CreateRootUser;
use App\Actions\Seeders\BloodSeeder;
use App\Actions\Seeders\StatesSeeder;
use Illuminate\Console\Command;

class SetupData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup application data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding root user ...');
        CreateRootUser::run();
        $this->info('Root user created.');

        $this->info('Seeding states started...');
        StatesSeeder::run();
        $this->info('Seeding states completed.');

        $this->info('Seeding Blood Types...');
        BloodSeeder::run();
        $this->info('Blood Types Completed.');
    }
}
