<?php

namespace Tests\Feature\Queries;

use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * @var \App\User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create([
            'name'     => 'Frodo Baggins',
            'email'    => 'frodo@bag.end',
            'password' => 'MyPrecious1'
        ]);
    }

    public function testQueryUsersGet(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                users(orderBy: [ {field: "name", order: DESC} ], first: 51) {
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
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
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
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
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
