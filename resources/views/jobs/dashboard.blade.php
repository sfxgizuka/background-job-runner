<!DOCTYPE html>
<html lang="en">
<head>
    <title>Background Jobs Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Background Jobs Dashboard</h1>
            <form method="GET" action="/">
                <input type="hidden" name="run_job" value="1">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Run New Job
                </button>
            </form>
        </div>

        <!-- Active Jobs Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Active Jobs ({{ $activeJobs->count() }})</h2>
            <div class="bg-white rounded-lg shadow">
                @include('jobs.partials.jobs-table', ['jobs' => $activeJobs])
            </div>
        </div>

        <!-- Completed Jobs Section -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Completed Jobs ({{ $completedJobs->count() }})</h2>
            <div class="bg-white rounded-lg shadow">
                @include('jobs.partials.jobs-table', ['jobs' => $completedJobs])
            </div>
        </div>
    </div>
</body>
</html>
