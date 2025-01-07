<?php

namespace App\Livewire;

use App\Models\WeatherAlert;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class WeatherAlertsTable extends Component
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
     * @var array<string>
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

    /**
     * Toggle the "enabled" status of a weather alert.
     *
     * @param int $id
     * @return void
     */
    public function toggleEnabled(int $id): void
    {
        $weatherAlert = WeatherAlert::findOrFail($id);
        $weatherAlert->enabled = !$weatherAlert->enabled;
        $weatherAlert->save();

        session()->flash('message', 'Alert status updated successfully.');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $weatherAlerts = WeatherAlert::query()
            ->where(['user_id' => Auth::id()])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.weather-alerts-table', ['weatherAlerts' => $weatherAlerts]);
    }
}
