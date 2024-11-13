<?php

namespace App\Http\Controllers;

use App\Models\BackgroundJob;
use Illuminate\Http\Request;

class JobDashboardController extends Controller
{
    public function index()
    {
        $jobs = BackgroundJob::orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('jobs.dashboard', compact('jobs'));
    }

    public function cancel($id)
    {
        $job = BackgroundJob::findOrFail($id);
        if ($job->status === 'running' || $job->status === 'pending') {
            $job->update(['status' => 'failed', 'error_message' => 'Cancelled by admin']);
        }
        return redirect()->back()->with('success', 'Job cancelled successfully');
    }
}
