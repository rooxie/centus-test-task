<?php

namespace App\Services\WeatherService;

interface WeatherServiceAdapterInterface
{
    /**
     * Get the weather for a specific location.
     *
     * @param string $location
     * @return WeatherReport
     */
    public function getWeather(string $location): WeatherReport;
}
