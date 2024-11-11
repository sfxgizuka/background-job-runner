<?php

use App\Services\BackgroundJobRunner;

if (!function_exists('runBackgroundJob')) {
    function runBackgroundJob($className, $methodName, $parameters = [])
    {
        $runner = new BackgroundJobRunner();
        $command = "php " . base_path('artisan') . " background:run \"$className\" \"$methodName\" " . escapeshellarg(json_encode($parameters));
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen("start /B " . $command, "r"));
        } else {
            exec($command . " > /dev/null &");
        }
    }
}
