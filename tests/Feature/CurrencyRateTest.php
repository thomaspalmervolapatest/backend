<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CurrencyRateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_list_of_currency_rates_is_returned(): void
    {
        self::loginViaPassport();

        $this->get('api/currency-rates')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'currency',
                        'rate',
                        'common',
                    ],
                ],
            ]);
    }
}
