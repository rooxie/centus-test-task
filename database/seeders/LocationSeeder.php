<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;

class LocationSeeder extends Seeder
{
    /**
     * @see https://packagist.org/packages/annexare/countries-list
     */
    protected const COUNTRIES_CSV = 'vendor/annexare/countries-list/dist/countries.csv';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = trim(file_get_contents(base_path(self::COUNTRIES_CSV)));
        $lines = explode(PHP_EOL, $csv);
        $header = collect(str_getcsv(array_shift($lines)));
        $countries = collect($lines)->map(fn($row) => $header->combine(str_getcsv($row)));

        foreach ($countries as $country) {
            try {
                Location::create([
                    'name' => $country->get('Capital') ?: $country->get('Name'),
                    'country' => $country->get('Code'),
                ]);
            } catch (UniqueConstraintViolationException) {
                continue;
            }
        }
    }
}
