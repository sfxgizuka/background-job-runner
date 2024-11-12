<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Exception;

class BackgroundJobRunner
{
    protected $allowedClasses = [
        // 'App\Jobs\ExampleJob',
        'App\Services\SomeServiceClass',
    ];

    // Add configurable retry delay
    protected $retryDelay = 1; // seconds

    // Add job timeout
    protected $timeout = 30; // seconds

    public function executeJobOnce($className, $methodName, $parameters = [])
    {
        if (!in_array($className, $this->allowedClasses)) {
            $this->logError("Unauthorized class: $className");
            throw new Exception("Unauthorized class execution attempt.");
        }

        try {
            set_time_limit($this->timeout);

            if (!class_exists($className)) {
                throw new Exception("Class $className does not exist.");
            }

            $instance = app($className); // Use Laravel's service container
            if (!method_exists($instance, $methodName)) {
                throw new Exception("Method $methodName does not exist in $className.");
            }

            $result = call_user_func_array([$instance, $methodName], $parameters);
            $this->logSuccess($className, $methodName);
            return $result;

        } catch (Exception $e) {
            $this->logError("Failed to execute $className::$methodName. Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function executeJob($className, $methodName, $parameters = [], $retries = 3)
    {
        $attempt = 0;
        $lastException = null;

        while ($attempt < $retries) {
            try {
                return $this->executeJobOnce($className, $methodName, $parameters);
            } catch (Exception $e) {
                $lastException = $e;
                $attempt++;

                if ($attempt >= $retries) {
                    $this->logError("Max retry attempts ($retries) reached for $className::$methodName. Final error: " . $e->getMessage());
                    throw $lastException;
                }

                sleep($this->retryDelay * $attempt); // Progressive delay
            }
        }
    }

    protected function logSuccess($className, $methodName)
    {
        Log::channel('background_jobs')->info("Job executed successfully: $className::$methodName", [
            'timestamp' => now(),
            'class' => $className,
            'method' => $methodName
        ]);
    }

    protected function logError($message)
    {
        Log::channel('background_jobs_errors')->error($message, [
            'timestamp' => now(),
            'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)
        ]);
    }
}
