<?php

namespace App\Providers;

use App\Repositories\CountryRepository;
use App\Repositories\CountryRepositoryInterface;
use App\Services\Alaouy\Youtube\YouTube;
use App\Services\Ranking\RankingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
