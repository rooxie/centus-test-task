<?php

namespace App\Services\WeatherService;

class FakeWeatherService implements WeatherServiceAdapterInterface
{
    /**
     * @param string $location
     * @return WeatherReport
     */
    public function getWeather(string $location): WeatherReport
    {
        return new WeatherReport(
            location: $location,
            temperature: rand(-2, 35),
            precipitation: rand(0, 100),
            uv: rand(0, 14)
        );
    }
}
