<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StopDockerContainer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:stop-dc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to stop the Docker container with the Mysql database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $command = 'docker stop mysql_container';
        exec($command,$output,$return);

       if ($return === 0) {
           $this->info('Docker container stopped successfully.');
       } else {
           $this->error('Failed to stop Docker container.');
       }
    }
}
