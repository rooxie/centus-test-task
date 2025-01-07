<?php

namespace App\Services\RemoteWeatherService;

use App\Models\Location;
use Carbon\Carbon;
use Throwable;

/**
 * This interface must be implemented by all weather service API adapters.
 */
interface RemoteWeatherServiceApiAdapterInterface
{
    /**
     * Get the weather for a specific location.
     *
     * @param Location $location
     * @return WeatherReport
     * @throws Throwable
     */
    public function getWeather(Location $location, Carbon $date): WeatherReport;
}
