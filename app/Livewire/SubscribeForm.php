<?php

namespace App\Livewire;

use App\Models\WeatherAlert;
use App\Services\LocationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubscribeForm extends Component
{
    public $selected_location_id = null;
    public $locations = [];
    public $notification_method = 'email';
    public $precipitation = 0;
    public $uv = 0;

    // Validation rules
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

    public function mount(LocationService $locationService): void
    {
        $this->locations = $locationService->getAll();
    }

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
            'precipitation' => fake()->numberBetween(0, 100),
            'uv' => fake()->numberBetween(0, 14),
            'is_active' => true,
        ]);

        $this->reset(['selected_location_id', 'precipitation', 'uv']);

        session()->flash('message', 'Subscription successfully added.');

        $this->dispatch('weatherAlertCreated');
    }

    public function render()
    {
        return view('livewire.subscribe-form');
    }
}
