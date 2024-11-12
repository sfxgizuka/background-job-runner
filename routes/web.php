<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-background-job', function () {
    // Example: Run the job in the background
    runBackgroundJob('App\Services\SomeServiceClass', 'processTask', ['param1', 'param2']);

    return response()->json(['status' => 'Job is running in the background']);
});
