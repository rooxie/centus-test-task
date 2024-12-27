<?php

namespace App\Providers;

use App\Repositories\LocationRepository;
use App\Repositories\LocationRepositoryInterface;
use App\Services\WeatherService\FakeWeatherService;
use App\Services\WeatherService\WeatherServiceAdapterInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(WeatherServiceAdapterInterface::class, FakeWeatherService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
