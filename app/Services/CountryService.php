<?php

namespace App\Services;

use App\Models\Country;
use App\Repositories\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CountryService
{
    /**
     * @param CountryRepositoryInterface $countryRepository
     */
    public function __construct(protected CountryRepositoryInterface $countryRepository)
    {
        //
    }

    /**
     * @return Collection<Country>
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAll(): Collection
    {
        if ($countries = Cache::get('countries')) {
            return $countries;
        }

        $countries = $this->countryRepository->all();
        Cache::set('countries', $countries);

        return $countries;
    }
}
