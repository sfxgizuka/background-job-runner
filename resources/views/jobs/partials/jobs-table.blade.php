<table class="min-w-full">
    <thead>
        <tr>
            <th class="px-6 py-3 border-b">ID</th>
            <th class="px-6 py-3 border-b">Job</th>
            <th class="px-6 py-3 border-b">Status</th>
            <th class="px-6 py-3 border-b">Created</th>
            <th class="px-6 py-3 border-b">Updated</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jobs as $job)
            <tr>
                <td class="px-6 py-4">{{ $job->id }}</td>
                <td class="px-6 py-4">{{ $job->class_name }}::{{ $job->method_name }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-sm
                        @if($job->status === 'completed') bg-green-200
                        @elseif($job->status === 'failed') bg-red-200
                        @elseif($job->status === 'running') bg-blue-200
                        @else bg-yellow-200 @endif">
                        {{ $job->status }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ $job->created_at->diffForHumans() }}</td>
                <td class="px-6 py-4">{{ $job->updated_at->diffForHumans() }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No jobs found</td>
            </tr>
        @endforelse
    </tbody>
</table>
