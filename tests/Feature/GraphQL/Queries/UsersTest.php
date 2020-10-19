<?php

namespace Tests\Feature\GraphQL\Queries;

use App\Models\User;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * @var \App\Models\User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'name'     => 'Frodo Baggins',
            'email'    => 'frodo@bag.end',
            'password' => \Hash::make('MyPrecious1')
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'Accept'        => 'application/json',
        ]);
    }

    public function testQueryUserMe(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                me {
                    id,
                    name
                }
            }
        ');

        $user = $response->json('data.me');
        $this->assertEquals('Frodo Baggins', $user['name']);
    }

    public function testQueryUsersGet(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                users(orderBy: [ {field: NAME, order: DESC} ], first: 51) {
                    data {
                        id,
                        name
                    }
                }
            }
        ');

        $names = $response->json('data.*.data.*.name');
        $this->assertContains('Frodo Baggins', $names);
    }

    public function testQueryUserGet(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                user(id: ' . $this->user->id . ') {
                    id,
                    name
                }
            }
        ');

        $user = $response->json('data.user');
        $this->assertEquals('Frodo Baggins', $user['name']);
    }

    public function testQueryUserGetError(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                user(id: ' . ($this->user->id + 1) . ') {
                    id,
                    name
                }
            }
        ');

        $user = $response->json('data.user');
        $this->assertNull($user);
    }

}
