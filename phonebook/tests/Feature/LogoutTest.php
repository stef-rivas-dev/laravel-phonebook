<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ];

        $this->json('get', TestCase::API_PREFIX . '/contacts', [], $headers)->assertStatus(200);
        $this->json('post', TestCase::API_PREFIX . '/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken()
    {
        // Simulating login
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ];

        // Simulating logout
        $user->api_token = null;
        $user->save();

        $this->json('get', TestCase::API_PREFIX . '/contacts', [], $headers)->assertStatus(401);
    }
}
