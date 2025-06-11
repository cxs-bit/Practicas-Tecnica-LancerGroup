<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunDockerContainer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-dc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to run the Docker container with the Mysql database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $command = 'docker-compose up -d';
        exec($command, $output, $return);

        if ($return === 0) {
            $this->info('Docker container started successfully.');
        } else {
            $this->error('Failed to start Docker container.');
        }
    }
}
