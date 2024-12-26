<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class CountryRepository implements CountryRepositoryInterface
{
    /**
     * @return Collection<Country>
     */
    public function all(): Collection
    {
        return Country::all();
    }
}
