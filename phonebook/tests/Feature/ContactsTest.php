<?php

namespace Tests\Feature;

use App\User;
use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
{
    public function testsContactsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'label' => 'Test',
            'phone_number' => '11111111111',
            'email' => 'test@test.com',
            'user_id' => 1,
        ];

        $this->json('POST', TestCase::API_PREFIX . '/contacts', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                'label' => 'Test',
                'phone_number' => '11111111111',
                'email' => 'test@test.com',
                'user_id' => 1,
            ]);
    }

    public function testsContactsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $contact = factory(Contact::class)->create([
            'label' => 'Test',
            'phone_number' => '11111111111',
            'email' => 'test@test.com',
            'user_id' => 1,
        ]);

        $payload = [
            'label' => '2Test',
            'phone_number' => '22222222222',
            'email' => '2test@test.com',
            'user_id' => 2,
        ];

        $response = $this->json('PUT', TestCase::API_PREFIX . '/contacts/' . $contact->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'label' => '2Test',
                'phone_number' => '22222222222',
                'email' => '2test@test.com',
                'user_id' => 2,
            ]);
    }

    public function testsArtilcesAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $contact = factory(Contact::class)->create([
            'label' => 'Test',
            'phone_number' => '11111111111',
            'email' => 'test@test.com',
            'user_id' => 1,
        ]);

        $this->json('DELETE', TestCase::API_PREFIX . '/contacts/' . $contact->id, [], $headers)
            ->assertStatus(204);
    }

    public function testContactsAreListedCorrectly()
    {
        factory(Contact::class)->create([
            'label' => 'Test',
            'phone_number' => '11111111111',
            'email' => 'test@test.com',
            'user_id' => 1,
        ]);

        factory(Contact::class)->create([
            'label' => '2Test',
            'phone_number' => '22222222222',
            'email' => '2test@test.com',
            'user_id' => 2,
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', TestCase::API_PREFIX . '/contacts', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [
                    'label' => 'Test',
                    'phone_number' => '11111111111',
                    'email' => 'test@test.com',
                    'user_id' => 1,
                ],
                [
                    'label' => '2Test',
                    'phone_number' => '22222222222',
                    'email' => '2test@test.com',
                    'user_id' => 2,
                ],
            ])
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'label',
                    'phone_number',
                    'email',
                    'user_id',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
