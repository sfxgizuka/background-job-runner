<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Exception;

class BackgroundJobRunner
{
    protected $allowedClasses = [
        // List fully qualified class names here
        'App\Jobs\ExampleJob',
        'App\Services\SomeServiceClass',
    ];

    public function executeJobOnce($className, $methodName, $parameters = [])
    {
        if (!in_array($className, $this->allowedClasses)) {
            $this->logError("Unauthorized class: $className");
            throw new Exception("Unauthorized class execution attempt.");
        }

        try {
            if (!class_exists($className)) {
                throw new Exception("Class $className does not exist.");
            }

            $instance = new $className();
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
        while ($attempt < $retries) {
            try {
                $this->executeJobOnce($className, $methodName, $parameters);
                return; // Exit if successful
            } catch (Exception $e) {
                $attempt++;
                if ($attempt >= $retries) {
                    $this->logError("Max retry attempts reached for $className::$methodName. Error: " . $e->getMessage());
                    throw $e;
                }
                sleep(1); // Add delay before retry
            }
        }
    }

    protected function logSuccess($className, $methodName)
    {
        Log::channel('background_jobs')->info("Job executed successfully: $className::$methodName at " . now());
    }

    protected function logError($message)
    {
        Log::channel('background_jobs_errors')->error($message . " at " . now());
    }
}
