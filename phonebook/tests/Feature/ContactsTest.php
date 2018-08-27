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
        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ];
        $payload = [
            'label' => 'Test',
            'phone_number' => '11111111111',
            'email' => 'test@test.com',
            'user_id' => 1,
        ];

        $this->json('POST', TestCase::API_PREFIX . '/contacts', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                "type" => "contact",
                "id" => 1,
                "attributes" => [
                    "user_id" => 1,
                    "label" => "Test",
                    "phone_number" => "11111111111",
                    "email" => "test@test.com",
                ],
                "links" => [
                    "self" => "http://localhost/v1/contacts/1"
                ],
            ]);
    }

    public function testsContactsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ];
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
                "type" => "contact",
                "id" => 1,
                "attributes" => [
                    "user_id" => 2,
                    "label" => "2Test",
                    "phone_number" => "22222222222",
                    "email" => "2test@test.com",
                ],
                "links" => [
                    "self" => "http://localhost/v1/contacts/1"
                ],
            ]);
    }

    public function testsArtilcesAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ];
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
        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ];

        $response = $this->json('GET', TestCase::API_PREFIX . '/contacts', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    [
                        "type" => "contact",
                        "id" => 1,
                        "attributes" => [
                            "user_id" => 1,
                            "label" => "Test",
                            "phone_number" => 11111111111,
                            "email" => "test@test.com",
                        ],
                        "links" => [
                            "self" => "http://localhost/v1/contacts/1"
                        ]
                    ],
                    [
                        "type" => "contact",
                        "id" => 2,
                        "attributes" => [
                            "user_id" => 2,
                            "label" => "2Test",
                            "phone_number" => 22222222222,
                            "email" => "2test@test.com",
                        ],
                        "links" => [
                            "self" => "http://localhost/v1/contacts/2"
                        ]
                    ]
                ],
                "links" => [
                    "first" => "http://localhost/v1/contacts?page=1",
                    "last" => "http://localhost/v1/contacts?page=1",
                    "prev" => null,
                    "next" => null,
                    "self" => "http://localhost/v1/contacts"
                ],
                "meta" => [
                    "current_page" => 1,
                    "from" => 1,
                    "last_page" => 1,
                    "path" => "http://localhost/v1/contacts",
                    "per_page" => 15,
                    "to" => 2,
                    "total" => 2
                ]
            ]);
    }
}
