<?php

namespace App\Services\WeatherService;

use Carbon\Carbon;
use InvalidArgumentException;

class WeatherReport
{
    /**
     * @var Carbon
     */
    protected Carbon $time;

    /**
     * @param string $location
     * @param float $temperature
     * @param int $precipitation
     * @param int $uv
     */
    public function __construct(
        protected string $location,
        protected float $temperature,
        protected int $precipitation,
        protected int $uv
    ) {
        if (trim($this->location) === '') {
            throw new InvalidArgumentException('Location cannot be empty');
        }

        if ($this->precipitation < 0 || $this->precipitation > 100) {
            throw new InvalidArgumentException('Precipitation must be between 0 and 100');
        }

        if ($this->uv < 0 || $this->uv > 100) {
            throw new InvalidArgumentException('UV must be between 0 and 100');
        }

        $this->time = Carbon::now();
    }

    /**
     * @return Carbon
     */
    public function getTime(): Carbon
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getLocation(): string
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
