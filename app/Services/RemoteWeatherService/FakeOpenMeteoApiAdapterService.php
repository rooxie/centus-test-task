<?php

namespace App\Services\RemoteWeatherService;

use App\Models\Location;
use Carbon\Carbon;
use Throwable;

class FakeOpenMeteoApiAdapterService implements RemoteWeatherServiceApiAdapterInterface
{
    /**
     * No key is required for the fake API.
     *
     * @param string $apiKey
     */
    public function __construct(protected string $apiKey)
    {
        //
    }

    /**
     * @param Location $location
     * @param Carbon $date
     * @return WeatherReport
     * @throws Throwable
     */
    public function getWeather(Location $location, Carbon $date): WeatherReport
    {
        $response = $this->getFakeApiResponse(
            $location,
            $date->format('Y-m-d')
        );

        return new WeatherReport(
            $date,
            $location,
            $response['hourly']['temperature_2m'][$date->hour],
            $response['hourly']['precipitation_probability'][$date->hour],
            $response['hourly']['uv_index'][$date->hour]
        );
    }

    /**
     * Get immitation of the response from Open-Meteo API.
     *
     * @param Location $location
     * @param string $date
     * @return array
     */
    protected function getFakeApiResponse(Location $location, string $date): array
    {
        return [
            'location' => $location->name,
            'hourly' => [
                'time' => [
                    0 => $date . 'T00:00',
                    1 => $date . 'T01:00',
                    2 => $date . 'T02:00',
                    3 => $date . 'T03:00',
                    4 => $date . 'T04:00',
                    5 => $date . 'T05:00',
                    6 => $date . 'T06:00',
                    7 => $date . 'T07:00',
                    8 => $date . 'T08:00',
                    9 => $date . 'T09:00',
                    10 => $date . 'T10:00',
                    11 => $date . 'T11:00',
                    12 => $date . 'T12:00',
                    13 => $date . 'T13:00',
                    14 => $date . 'T14:00',
                    15 => $date . 'T15:00',
                    16 => $date . 'T16:00',
                    17 => $date . 'T17:00',
                    18 => $date . 'T18:00',
                    19 => $date . 'T19:00',
                    20 => $date . 'T20:00',
                    21 => $date . 'T21:00',
                    22 => $date . 'T22:00',
                    23 => $date . 'T23:00',
                ],
                'temperature_2m' => [
                    0 => rand(-15, 35),
                    1 => rand(-15, 35),
                    2 => rand(-15, 35),
                    3 => rand(-15, 35),
                    4 => rand(-15, 35),
                    5 => rand(-15, 35),
                    6 => rand(-15, 35),
                    7 => rand(-15, 35),
                    8 => rand(-15, 35),
                    9 => rand(-15, 35),
                    10 => rand(-15, 35),
                    11 => rand(-15, 35),
                    12 => rand(-15, 35),
                    13 => rand(-15, 35),
                    14 => rand(-15, 35),
                    15 => rand(-15, 35),
                    16 => rand(-15, 35),
                    17 => rand(-15, 35),
                    18 => rand(-15, 35),
                    19 => rand(-15, 35),
                    20 => rand(-15, 35),
                    21 => rand(-15, 35),
                    22 => rand(-15, 35),
                    23 => rand(-15, 35),
                ],
                'precipitation_probability' => [
                    0 => rand(0, 100),
                    1 => rand(0, 100),
                    2 => rand(0, 100),
                    3 => rand(0, 100),
                    4 => rand(0, 100),
                    5 => rand(0, 100),
                    6 => rand(0, 100),
                    7 => rand(0, 100),
                    8 => rand(0, 100),
                    9 => rand(0, 100),
                    10 => rand(0, 100),
                    11 => rand(0, 100),
                    12 => rand(0, 100),
                    13 => rand(0, 100),
                    14 => rand(0, 100),
                    15 => rand(0, 100),
                    16 => rand(0, 100),
                    17 => rand(0, 100),
                    18 => rand(0, 100),
                    19 => rand(0, 100),
                    20 => rand(0, 100),
                    21 => rand(0, 100),
                    22 => rand(0, 100),
                    23 => rand(0, 100),
                ],
                'uv_index' => [
                    0 => rand(0, 14),
                    1 => rand(0, 14),
                    2 => rand(0, 14),
                    3 => rand(0, 14),
                    4 => rand(0, 14),
                    5 => rand(0, 14),
                    6 => rand(0, 14),
                    7 => rand(0, 14),
                    8 => rand(0, 14),
                    9 => rand(0, 14),
                    10 => rand(0, 14),
                    11 => rand(0, 14),
                    12 => rand(0, 14),
                    13 => rand(0, 14),
                    14 => rand(0, 14),
                    15 => rand(0, 14),
                    16 => rand(0, 14),
                    17 => rand(0, 14),
                    18 => rand(0, 14),
                    19 => rand(0, 14),
                    20 => rand(0, 14),
                    21 => rand(0, 14),
                    22 => rand(0, 14),
                    23 => rand(0, 14),
                ],
            ],
        ];
    }
}
