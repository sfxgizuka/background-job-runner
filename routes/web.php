<?php

use Illuminate\Support\Facades\Route;
use App\Models\BackgroundJob;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $activeJobs = BackgroundJob::whereIn('status', ['pending', 'running'])
        ->orderBy('created_at', 'desc')
        ->get();

    $completedJobs = BackgroundJob::whereIn('status', ['completed', 'failed'])
        ->orderBy('created_at', 'desc')
        ->get();
    if ($request->has('run_job')) {
        $params = ['value1', 'value2'];  // Sequential array values
        runBackgroundJob('App\Services\SomeServiceClass', 'processTask', $params);
    }
    return view('jobs.dashboard', compact('activeJobs', 'completedJobs'));
});
