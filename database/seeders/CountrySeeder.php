<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = trim(file_get_contents(base_path('vendor/annexare/countries-list/dist/countries.csv')));
        $lines = explode(PHP_EOL, $csv);
        $header = collect(str_getcsv(array_shift($lines)));
        $countries = collect($lines)->map(fn($row) => $header->combine(str_getcsv($row)));

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country->get('Code')],
                [
                    'code' => $country->get('Code'),
                    'name' => $country->get('Name'),
                    'capital' => $country->get('Capital') ?: $country->get('Name'),
                ]
            );
        }
    }
}
