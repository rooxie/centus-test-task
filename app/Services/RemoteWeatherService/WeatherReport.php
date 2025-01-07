<?php

namespace App\Services\RemoteWeatherService;

use App\Models\Location;
use Carbon\Carbon;
use InvalidArgumentException;

class WeatherReport
{
    /**
     * @param Carbon $time
     * @param Location $location
     * @param float $temperature
     * @param int $precipitation
     * @param int $uv
     */
    public function __construct(
        protected Carbon $time,
        protected Location $location,
        protected float $temperature,
        protected int $precipitation,
        protected int $uv
    ) {
        if (!$this->location->id) {
            throw new InvalidArgumentException('Location must have an ID');
        }

        if ($this->precipitation < 0 || $this->precipitation > 100) {
            throw new InvalidArgumentException('Precipitation must be between 0 and 100');
        }

        if ($this->uv < 0 || $this->uv > 100) {
            throw new InvalidArgumentException('UV must be between 0 and 100');
        }
    }

    /**
     * @return Carbon
     */
    public function getTime(): Carbon
    {
        return $this->time;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @return int
     */
    public function getPrecipitation(): int
    {
        return $this->precipitation;
    }

    /**
     * @return int
     */
    public function getUv(): int
    {
        return $this->uv;
    }
}
