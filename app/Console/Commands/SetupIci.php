<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupIci extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:ici';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up ICI...school ...');
        \App\Actions\SetupIci::run();
        $this->info('finish settin up ici, Margarita and Arturo were setup as users ...');
    }
}
