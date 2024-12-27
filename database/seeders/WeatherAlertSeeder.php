<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\WeatherAlert;
use Illuminate\Database\Seeder;

class WeatherAlertSeeder extends Seeder
{
    protected const CITIES = [
        'London',
        'Paris',
        'Berlin',
        'Madrid',
        'Rome',
        'Lisbon',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::CITIES as $city) {
            WeatherAlert::create([
                'location' => Location::where('name', $city)->first()->id,
                'channel_type' => 'email',
                'channel_identifier' => fake()->email(),
                'precipitation' => fake()->numberBetween(0, 100),
                'uv' => fake()->numberBetween(0, 14),
            ]);
        }
    }
}
