<div>
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-4 text-green-500">
            {{ session('message') }}
        </div>
    @endif

    <!-- Error Message -->
    @if (session()->has('error'))
        <div class="mb-4 text-red-500">
            {{ session('error') }}
        </div>
    @endif

    <h2 class="text-xl font-semibold mb-4">
        {{ __('Subscribe to Weather Alerts') }}
    </h2>

    <!-- Subscription Form -->
    <form wire:submit.prevent="subscribe">

        <!-- Location Select Box -->
        <div class="mb-4">
            <label for="location" class="block text-sm font-medium text-gray-700">
                {{ __('Location') }}
            </label>
            <select
                id="location"
                wire:model="location_id"
                class="mt-1 block w-full border {{ $errors->has('location_id') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm p-2 bg-white"
            >
                <option value="" selected>
                    {{ __('Select a location') }}
                </option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
            @error('location_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Notification Channel Select Box -->
        <div class="mb-4">
            <label for="channel" class="block text-sm font-medium text-gray-700">
                {{ __('Notification Channel') }}
            </label>
            <select
                id="channel"
                wire:model="channel"
                class="mt-1 block w-full border {{ $errors->has('channel') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm p-2 bg-white"
            >
                <option value="email">{{ __('Email') }}</option>
                <option value="webpush">{{ __('Web Push') }}</option>
            </select>
            @error('channel')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Metric Select Box -->
        <div class="mb-4">
            <label for="metric" class="block text-sm font-medium text-gray-700">
                {{ __('Metric') }}
            </label>
            <select
                id="metric"
                wire:model="metric"
                class="mt-1 block w-full border {{ $errors->has('metric') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm p-2 bg-white"
            >
                <option value="precipitation">{{ __('Precipitation') }}</option>
                <option value="uv">{{ __('UV Index') }}</option>
            </select>
            @error('metric')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Threshold Input -->
        <div class="mb-4">
            <label for="threshold" class="block text-sm font-medium text-gray-700">
                {{ __('Threshold') }}
            </label>
            <input
                type="number"
                id="threshold"
                wire:model="threshold"
                class="mt-1 block w-full border {{ $errors->has('threshold') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm p-2"
                min="1"
                max="100"
            >
            <p class="text-sm text-gray-500">
                {{ $metric === 'uv' ? __('Value must be between 1 and 40') : __('Value must be between 1 and 100') }}
            </p>
            @error('threshold')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>


        <div>
            <x-button>
                {{ __('Subscribe') }}
            </x-button>
        </div>
    </form>
</div>
