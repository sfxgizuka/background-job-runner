<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BackgroundJobRunner;

class RunBackgroundJob extends Command
{
    protected $signature = 'background:run {className} {methodName} {parameters?}';
    protected $description = 'Execute a job in the background';

    public function handle()
    {
        $className = $this->argument('className');
        $methodName = $this->argument('methodName');
        $parameters = json_decode($this->argument('parameters'), true) ?: [];

        $runner = new BackgroundJobRunner();

        try {
            $runner->executeJob($className, $methodName, $parameters);
            $this->info("Job $className::$methodName executed successfully.");
        } catch (Exception $e) {
            $this->error("Failed to execute job: " . $e->getMessage());
        }
    }
}
