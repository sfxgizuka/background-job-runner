<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobDashboardController;
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
        $params = (object)[
            'param1' => $request->input('param1', 'default1'),
            'param2' => $request->input('param2', 'default2')
        ];
        runBackgroundJob('App\Services\SomeServiceClass', 'processTask', $params);
    }

    return view('jobs.dashboard', compact('activeJobs', 'completedJobs'));
});
Route::get('/jobs/dashboard', [JobDashboardController::class, 'index'])->name('jobs.dashboard');
Route::post('/jobs/{id}/cancel', [JobDashboardController::class, 'cancel'])->name('jobs.cancel');
