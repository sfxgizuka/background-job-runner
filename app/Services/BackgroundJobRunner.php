<?php

namespace App\Services;

use App\Models\BackgroundJob;
use Illuminate\Support\Facades\Log;
use Exception;

class BackgroundJobRunner
{
    protected $allowedClasses = [
        'App\Services\SomeServiceClass',
    ];

    protected $retryDelay = 1;
    protected $timeout = 30;

    public function executeJob($className, $methodName, $parameters = [])
    {
        // First log the incoming job request
        Log::channel('background_jobs')->info("Starting job execution", [
            'class' => $className,
            'method' => $methodName,
            'parameters' => $parameters
        ]);

        // Create job record
        $job = BackgroundJob::create([
            'class_name' => $className,
            'method_name' => $methodName,
            'parameters' => $parameters,
            'status' => 'pending'
        ]);

        try {
            // Update status to running and log
            $job->update(['status' => 'running']);
            Log::channel('background_jobs')->info("Job status updated to running", ['job_id' => $job->id]);

            // Execute the job
            $result = $this->executeJobOnce($className, $methodName, $parameters);

            // Update success status and log
            $job->update(['status' => 'completed']);
            Log::channel('background_jobs')->info("Job completed successfully", [
                'job_id' => $job->id,
                'result' => $result
            ]);

            return $result;

        } catch (Exception $e) {
            // Log error and update status
            Log::channel('background_jobs_errors')->error("Job execution failed", [
                'job_id' => $job->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $job->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    protected function executeJobOnce($className, $methodName, $parameters = [])
    {
        if (!in_array($className, $this->allowedClasses)) {
            throw new Exception("Unauthorized class: $className");
        }

        if (!class_exists($className)) {
            throw new Exception("Class $className does not exist");
        }

        $instance = app($className);
        if (!method_exists($instance, $methodName)) {
            throw new Exception("Method $methodName does not exist in $className");
        }

        return call_user_func_array([$instance, $methodName], $parameters);
    }
}
