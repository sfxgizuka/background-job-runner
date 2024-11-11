// app/Helpers/backgroundJobHelper.php

use App\Services\BackgroundJobRunner;

if (!function_exists('runBackgroundJob')) {
    /**
     * Helper function to run a background job
     *
     * @param string $className
     * @param string $methodName
     * @param array $parameters
     * @param int $retries
     * @return void
     */
    function runBackgroundJob($className, $methodName, $parameters = [], $retries = 3)
    {
        $runner = new BackgroundJobRunner();
        $runner->executeJob($className, $methodName, $parameters, $retries);
    }
}
