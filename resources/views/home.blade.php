<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mt-8">
                    @livewire('subscribe-form')
                </div>
                <hr class="m-4">
                <div class="mt-8">
                    @livewire('weather-alerts')
                </div>
            </div>
        </div>
    </div>

</x-app-layout>