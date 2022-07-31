<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var bool $mockConsoleOutput
     */
    public $mockConsoleOutput = false;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('passport:client --password --no-interaction');
    }

    /**
     * @return User
     */
    protected static function loginViaPassport(): User
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        return $user;
    }
}
