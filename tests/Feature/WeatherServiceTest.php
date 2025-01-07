<?php

namespace Tests\Feature;

use App\Livewire\SubscribeForm;
use App\Models\User;
use App\Services\LocationService;
use App\Services\WeatherService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * @var WeatherService
     */
    protected WeatherService $weatherService;

    protected LocationService $locationService;

    public function setUp(): void
    {
        parent::setUp();

        $this->weatherService = app()->make(WeatherService::class);
        $this->locationService = app()->make(LocationService::class);

    }

    public function test_no_weather_alerts_to_be_processed(): void
    {
        $this->assertDatabaseEmpty('weather_alerts');

        $yields = iterator_to_array($this->weatherService->processWeatherAlerts(Carbon::now()));

        $this->assertEquals('Processing 0 weather alerts', $yields[0]);
        $this->assertEquals('Finished', $yields[1]);
    }

    public function test_create_and_process_weather_alert(): void
    {
        $user = User::factory()->create();
        $location = $this->locationService->findByName('London');

        $this->actingAs($user);

        Livewire::test(SubscribeForm::class)
            ->set('location_id', $location->id)
            ->set('channel', 'email')
            ->set('metric', 'precipitation')
            ->set('threshold', 50)
            ->call('subscribe');

        $this->assertDatabaseHas('weather_alerts', [
            'user_id' => $user->id,
            'location_id' => $location->id,
            'channel' => 'email',
            'metric' => 'precipitation',
            'threshold' => 50,
            'enabled' => true,
        ]);

        $yields = iterator_to_array($this->weatherService->processWeatherAlerts(Carbon::now()));

        $this->assertEquals('Processing 1 weather alerts', $yields[0]);
        $this->assertTrue(str_starts_with($yields[1], "[{$location->name}]"));
        $this->assertEquals('Finished', $yields[2]);
    }
}
