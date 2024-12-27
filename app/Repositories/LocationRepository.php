<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationRepository implements LocationRepositoryInterface
{
    /**
     * @return Collection<Location>
     */
    public function all(): Collection
    {
        return Location::all();
    }
}
