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
                wire:model="selected_location_id"
                class="mt-1 block w-full border {{ $errors->has('selected_location_id') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm p-2 bg-white"
            >
                <option value="" selected>
                    {{ __('Select a location') }}
                </option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
            @error('selected_location_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Notification Method Select Box -->
        <div class="mb-4">
            <label for="notification_method" class="block text-sm font-medium text-gray-700">
                {{ __('Notification Method') }}
            </label>
            <select
                id="notification_method"
                wire:model="notification_method"
                class="mt-1 block w-full border {{ $errors->has('notification_method') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm p-2 bg-white"
            >
                <option value="email">
                    {{ __('Email') }}
                </option>
                <option value="webpush">
                    {{ __('Web Push') }}
                </option>
            </select>
            @error('notification_method')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Precipitation Integer Input -->
        <div class="mb-4">
            <label for="precipitation" class="block text-sm font-medium text-gray-700">
                {{ __('Precipitation') }}
            </label>
            <input
                type="number"
                id="precipitation"
                wire:model="precipitation"
                class="mt-1 block w-full border {{ $errors->has('precipitation') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm p-2"
                min="0"
                max="99"
            >
            <p class="text-sm text-gray-500">
                {{ __('Value must be between 0 and 99') }}
            </p>
            @error('precipitation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- UV Integer Input -->
        <div class="mb-4">
            <label for="uv" class="block text-sm font-medium text-gray-700">
                {{ __('UV Index') }}
            </label>
            <input
                type="number"
                id="uv"
                wire:model="uv"
                class="mt-1 block w-full border {{ $errors->has('uv') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm p-2"
                min="0"
                max="40"
            >
            <p class="text-sm text-gray-500">
                {{ __('Value must be between 0 and 40') }}
            </p>
            @error('uv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <x-button>
                {{ __('Subscribe') }}
            </x-button>
        </div>
    </form>
</div>
