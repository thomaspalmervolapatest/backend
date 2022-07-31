<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_a_user_can_successfully_login(): void
    {
        // generate a user
        $password = Str::random();
        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        // fetch the details of the password client
        $client = \DB::table('oauth_clients')->where('password_client', 1)->first();

        // create a token request and check the response
        $this->post('oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $user->email,
            'password' => $password,
            'scope' => '',
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'token_type', 'expires_in', 'access_token', 'refresh_token',
            ]);
    }

    /**
     * @return void
     */
    public function test_a_user_cannot_successfully_login_when_supplying_the_wrong_details(): void
    {
        // generate a user
        $password = Str::random();
        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        // fetch the details of the password client
        $client = \DB::table('oauth_clients')->where('password_client', 1)->first();

        // create a token request and check the response
        $this->post('oauth/token', [
            'grant_type' => 'not-the-users-password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $user->email,
            'password' => $password,
            'scope' => '',
        ])
            ->assertStatus(400);
    }

    /**
     * @return void
     */
    public function test_a_user_can_refresh_their_token(): void
    {
        // generate a user
        $password = Str::random();
        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        // fetch the details of the password client
        $client = \DB::table('oauth_clients')->where('password_client', 1)->first();

        // create a token request
        $response = $this->post('oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $user->email,
            'password' => $password,
            'scope' => '',
        ]);

        // check the response from initial token request
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token_type', 'expires_in', 'access_token', 'refresh_token',
            ]);

        // request a refresh and check the response
        $this->post('oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $response->json('refresh_token'),
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => '',
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'token_type', 'expires_in', 'access_token', 'refresh_token',
            ]);
    }
}
