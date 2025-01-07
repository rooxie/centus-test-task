<?php

namespace App\Providers;

use App\Repositories\LocationRepository;
use App\Repositories\LocationRepositoryInterface;
use App\Repositories\WeatherAlertRepository;
use App\Repositories\WeatherAlertRepositoryInterface;
use App\Services\RemoteWeatherService\FakeOpenMeteoApiAdapterService;
use App\Services\RemoteWeatherService\RemoteWeatherServiceApiAdapterInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(WeatherAlertRepositoryInterface::class, WeatherAlertRepository::class);
        $this->app->bind(RemoteWeatherServiceApiAdapterInterface::class, FakeOpenMeteoApiAdapterService::class);

        $this->app->singleton(FakeOpenMeteoApiAdapterService::class, function () {
            return new FakeOpenMeteoApiAdapterService(config('services.fake_open_meteo_api.key'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
