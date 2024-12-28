<?php

namespace App\Livewire;

use App\Models\WeatherAlert;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class WeatherAlerts extends Component
{
    use WithPagination;

    /**
     * @var int
     */
    protected int $perPage = 10;

    /**
     * @var string
     */
    protected string $paginationTheme = 'tailwind';

    /**
     * @var string[]
     */
    protected $listeners = ['weatherAlertCreated' => '$refresh'];

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        WeatherAlert::findOrFail($id)->delete();

        session()->flash('message', 'Record deleted successfully.');
    }

    public function render()
    {
        $weatherAlerts = WeatherAlert::query()
            ->where(['user_id' => Auth::id()])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.weather-alerts', ['weatherAlerts' => $weatherAlerts]);
    }
}