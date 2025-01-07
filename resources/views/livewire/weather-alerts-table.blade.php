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
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metric</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Threshold</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enabled</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Executed</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($weatherAlerts as $weatherAlert)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ strtoupper($weatherAlert->channel) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $weatherAlert->location->name }}, {{ $weatherAlert->location->country }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ strtoupper($weatherAlert->metric) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $weatherAlert->threshold }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $weatherAlert->enabled ? __('Yes') : __('No') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $weatherAlert->created_at->diffForHumans() }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $weatherAlert->executed_at?->diffForHumans() }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 space-x-2">
                    <x-danger-button wire:click="delete({{ $weatherAlert->id }})">{{ __('Delete') }}</x-danger-button>
                    <x-secondary-button wire:click="toggleEnabled({{ $weatherAlert->id }})">
                        {{ $weatherAlert->enabled ? __('Pause') : __('Resume') }}
                    </x-secondary-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $weatherAlerts->links() }}
    </div>
</div>
