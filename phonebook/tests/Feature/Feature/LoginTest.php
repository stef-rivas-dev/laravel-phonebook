<?php

namespace Tests\Feature\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', TestCase::API_PREFIX . '/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => [
                        "The email field is required."
                    ],
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ]);
    }

    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'test@test.com',
            'password' => bcrypt('1234'),
        ]);

        $payload = ['email' => 'test@test.com', 'password' => '1234'];

        $this->json('POST', TestCase::API_PREFIX . '/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);
    }
}
