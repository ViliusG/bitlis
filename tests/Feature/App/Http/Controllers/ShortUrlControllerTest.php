<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\ShortURL;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ShortUrlControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_simple_create_response_is_correct_with_good_structure()
    {
        $user = User::factory()->create();
        $originalUrl = 'https://google.com';
        $expiresInDays = 7;

        $requestBody = [
            'userId' => $user->id,
            'originalUrl' => $originalUrl,
            'shortUrl' => 'test'
        ];

        Config::set('app.url', 'localhost');
        Config::set('urls.default_expiry_time', $expiresInDays);

        $expectedResponse = [
            'userId' => $user->id,
            'originalUrl' => $originalUrl,
            'shortUrl' => 'localhost/test',
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertOk()
            ->assertJson($expectedResponse)
            ->assertJsonStructure([
                'id',
                'originalUrl',
                'shortUrl',
                'expiryDate'
            ]);
    }
    public function test_create_with_expire_in_days_provided()
    {
        $user = User::factory()->create();
        $expiresInDays = 3;

        $requestBody = [
            'userId' => $user->id,
            'originalUrl' => 'https://google.com',
            'shortUrl' => 'test',
            'expireInDays' => $expiresInDays,
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertJson(['expiryDate' => Carbon::now()->addDays($expiresInDays)->format('Y-m-d')]);
    }

    public function test_create_with_bad_expire_in_days_provided()
    {
        $user = User::factory()->create();
        $expiresInDays = 0;

        $requestBody = [
            'userId' => $user->id,
            'originalUrl' => 'https://google.com',
            'expireInDays' => $expiresInDays,
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertUnprocessable();
    }

    public function test_create_with_bad_url_provided()
    {
        $user = User::factory()->create();

        $requestBody = [
            'userId' => $user->id,
            'originalUrl' => 'google.com',
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertUnprocessable();
    }

    public function test_create_with_short_url_as_empty_string()
    {
        $user = User::factory()->create();

        $requestBody = [
            'userId' => $user->id,
            'originalUrl' => 'google.com',
            'shortUrl' => '',
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertUnprocessable();
    }

    public function test_create_with_non_alphanumeric_short_url()
    {
        $user = User::factory()->create();

        $requestBody = [
            'userId' => $user->id,
            'originalUrl' => 'google.com',
            'shortUrl' => '#$f2',
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertUnprocessable();
    }

    public function test_create_with_duplicate_short_url_provided()
    {
        $user = User::factory()->create();
        $url = 'coolUrl';

        ShortURL::factory()->create([
            'short_url' => $url,
        ]);

        $requestBody = [
            'userId' => $user->id,
            'originalUrl' => 'https://google.com',
            'shortUrl' => $url,
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertUnprocessable();
    }

    public function test_create_with_non_existing_user()
    {
        $requestBody = [
            'userId' => 1,
            'originalUrl' => 'https://google.com',
            'shortUrl' => 'test',
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertUnprocessable();
    }

    public function test_create_without_passing_original_url()
    {
        $user = User::factory()->create();

        $requestBody = [
            'userId' => $user->id,
            'shortUrl' => 'test',
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertUnprocessable();
    }

    public function test_create_without_short_url()
    {
        $user = User::factory()->create();

        $requestBody = [
            'userId' => $user->id,
            'originalUrl' => 'https://google.com',
        ];

        $this->withHeaders(['Accept' => 'application/json',])
            ->postJson('/api/short-url', $requestBody)
            ->assertOk();
    }
}
