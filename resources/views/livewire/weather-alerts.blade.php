<div>
    @if (session()->has('message'))
        <div class="mb-4 text-green-500">
            {{ session('message') }}
        </div>
    @endif

    <h2 class="text-xl font-semibold mb-4">
        {{ __('Your Weather Alerts') }}
    </h2>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Channel</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precipitation >=</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UV Index >=</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Executed</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($weatherAlerts as $weatherAlert)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ strtoupper($weatherAlert->channel_type) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $weatherAlert->location->name }}, {{ $weatherAlert->location->country }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $weatherAlert->precipitation }}%</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $weatherAlert->uv }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $weatherAlert->created_at->diffForHumans() }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $weatherAlert->executed_at?->diffForHumans() }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <x-danger-button wire:click="delete({{ $weatherAlert->id }})">{{ __('Delete') }}</x-danger-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $weatherAlerts->links() }}
    </div>
</div>
