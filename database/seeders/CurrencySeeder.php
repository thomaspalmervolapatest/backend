<?php

namespace Database\Seeders;

use App\Models\CurrencyRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['EUR', 'GBP', 'USD', 'AUD'])
            ->each(fn ($currency) => CurrencyRate::create([
                'currency' => $currency,
                'common' => fake()->boolean(),
                'rate' => fake()->numberBetween(0.5, 2.5),
            ]));
    }
}
