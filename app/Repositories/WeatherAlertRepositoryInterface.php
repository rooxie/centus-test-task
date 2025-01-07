<?php

namespace App\Repositories;

use App\Models\WeatherAlert;
use Illuminate\Database\Eloquent\Collection;

interface WeatherAlertRepositoryInterface
{
    /**
     * @return Collection<WeatherAlert>
     */
    public function enabled(): \Illuminate\Support\Collection;
}
