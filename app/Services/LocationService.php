<?php

namespace App\Services;

use App\Models\Location;
use App\Repositories\LocationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class LocationService
{
    /**
     * @param LocationRepositoryInterface $locationRepository
     */
    public function __construct(protected LocationRepositoryInterface $locationRepository)
    {
        //
    }

    /**
     * @return Collection<Location>
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAll(): Collection
    {
        if ($locations = Cache::get('locations')) {
            return $locations;
        }

        $locations = $this->locationRepository->all();
        Cache::set('locations', $locations);

        return $locations;
    }
}
