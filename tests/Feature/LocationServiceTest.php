<?php

namespace Tests\Feature;

use App\Services\LocationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * @var LocationService
     */
    protected LocationService $locationService;

    public function setUp(): void
    {
        parent::setUp();

        $this->locationService = app()->make(LocationService::class);
    }

    public function test_correct_number_of_countries(): void
    {
        $this->assertEquals(
            250,
            $this->locationService->getAll()->count(),
            'There must be 250 locations in the database.'
        );
    }

    public function test_search_works_correctly()
    {
        $searchExpectedMap = [
            'London' => 'London',
            'bErliN' => 'Berlin',
            'MADRID' => 'Madrid',
            ' seoul ' => 'Seoul',
            '   paris' => 'Paris',
            'toKyo   ' => 'Tokyo',
        ];

        foreach ($searchExpectedMap as $search => $expected) {
            $location = $this->locationService->findByName($search);
            $this->assertEquals($expected, $location->name, "Search for '{$search}' must return '{$expected}'.");
        }
    }
}
