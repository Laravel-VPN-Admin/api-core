<?php

namespace Tests\Feature;

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
            'name'     => 'test1',
            'email'    => 'test@mail.com',
            'password' => 'asdzxc'
        ]);
    }

    public function testQueriesUsers(): void
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

        $this->assertContains('test1', $names);
    }

    public function testMutatorsCreateUser(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createUser (name:"test_gql", email:"asd@mail.com", password:"asd") {
                id,
                name,
                created_at
              }
            }
        ');

        $name = $response->json('data.createUser.name');

        $this->assertEquals('test_gql', $name);
    }

}
