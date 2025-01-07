<?php

namespace App\Repositories;

use App\Models\WeatherAlert;
use Illuminate\Database\Eloquent\Collection;

class WeatherAlertRepository implements WeatherAlertRepositoryInterface
{
    /**
     * @return Collection<WeatherAlert>
     */
    public function enabled(): \Illuminate\Support\Collection
    {
        return WeatherAlert::query()->where('enabled', true)->get();
    }
}
