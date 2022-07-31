<?php

namespace App\Repositories;

use App\Models\CurrencyRate;
use Illuminate\Support\Collection;

class CurrencyRateRepository
{
    /**
     * Return a list of all available currency rates
     * @return Collection
     */
    public function getAllRates(): Collection
    {
        return CurrencyRate::get();
    }
}
