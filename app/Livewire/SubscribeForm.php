<?php

namespace App\Livewire;

use App\Models\WeatherAlert;
use App\Services\LocationService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Psr\SimpleCache\InvalidArgumentException as SimpleCacheInvalidArgumentException;

class SubscribeForm extends Component
{
    public int $location_id = 0;
    public ?Collection $locations = null;
    public string $channel = 'email';
    public string $metric = 'precipitation';
    public int $threshold = 0;

    /**
     * Subscription rules.
     *
     * @var array<string, array<string>
     */
    protected $rules = [
        'location_id' => [
            'required',
            'exists:locations,id',
        ],
        'channel' => [
            'required',
            'in:email,webpush',
        ],
        'metric' => [
            'required',
            'in:precipitation,uv',
        ],
        'threshold' => [
            'required',
            'integer',
            'min:1',
            'max:100',
        ],
    ];

    /**
     * Mount the component.
     *
     * @param LocationService $locationService
     * @return void
     * @throws SimpleCacheInvalidArgumentException
     */
    public function mount(LocationService $locationService): void
    {
        $this->locations = $locationService->getAll();
    }

    /**
     * Subscribe to weather alerts.
     *
     * @return void
     */
    public function subscribe(): void
    {
        $validatedData = $this->validate();

        try {
            WeatherAlert::create([
                'user_id' => Auth::id(),
                'location_id' => $validatedData['location_id'],
                'channel' => $validatedData['channel'],
                'metric' => $validatedData['metric'],
                'threshold' => $validatedData['threshold'],
                'enabled' => true,
            ]);
        } catch (UniqueConstraintViolationException) {
            session()->flash('error', 'This weather alert already exists.');
            return;
        }

        $this->reset(['location_id', 'metric', 'threshold']);

        session()->flash('message', 'Subscription successfully added.');
        $this->dispatch('weatherAlertCreated');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.subscribe-form');
    }
}
