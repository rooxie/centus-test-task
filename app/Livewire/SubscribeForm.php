<?php

namespace App\Livewire;

use App\Models\WeatherAlert;
use App\Services\LocationService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Psr\SimpleCache\InvalidArgumentException as SimpleCacheInvalidArgumentException;

class SubscribeForm extends Component
{
    public ?int $selected_location_id = null;
    public ?Collection $locations = null;
    public string $notification_method = 'email';
    public int $precipitation = 0;
    public int $uv = 0;

    /**
     * Subscription rules.
     *
     * @var array<string, array<string>
     */
    protected $rules = [
        'selected_location_id' => [
            'required',
            'exists:locations,id',
        ],
        'notification_method' => [
            'required',
            'in:email,webpush',
        ],
        'precipitation' => [
            'nullable',
            'integer',
            'min:0',
            'max:99',
        ],
        'uv' => [
            'nullable',
            'integer',
            'min:0',
            'max:40',
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

        if ($validatedData['precipitation'] < 1 && $validatedData['uv'] < 1) {
            session()->flash('error', "Precipitation and UV can't be both 0.");
            return;
        }

        WeatherAlert::create([
            'user_id' => Auth::id(),
            'location_id' => $validatedData['selected_location_id'],
            'channel_type' => $validatedData['notification_method'],
            'precipitation' => $validatedData['precipitation'],
            'uv' => $validatedData['uv'],
            'is_active' => true,
        ]);

        $this->reset(['selected_location_id', 'precipitation', 'uv']);

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
