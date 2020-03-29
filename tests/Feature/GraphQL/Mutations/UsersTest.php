<?php

namespace Tests\Feature\GraphQL\Mutations;

use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var \App\Models\Group
     */
    private $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create([
            'name'     => 'Frodo Baggins',
            'email'    => 'frodo@bag.end',
            'password' => 'MyPrecious1'
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'Accept'        => 'application/json',
        ]);

        $this->group = factory(\App\Models\Group::class)->create([
            'name' => 'Lord of the Rings',
        ]);
    }

    public function testMutationUserCreate(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createUser (
                input: {
                  name:"test_gql",
                  email:"asd@mail.com",
                  password:"asd",
                  groups: {
                    connect: [' . $this->group->id . ']
                  }
                }
              )
              {
                id,
                name,
                groups {
                  id,
                  name
                },
                created_at
              }
            }
        ');

        $user = $response->json('data.createUser');
        $this->assertEquals('test_gql', $user['name']);
        $this->assertDatabaseHas('users', [
            'name'  => 'test_gql',
            'email' => 'asd@mail.com'
        ]);

        $groups = $response->json('data.createUser.groups');
        $this->assertContains([
            'id'   => (string) $this->group->id,
            'name' => $this->group->name,
        ], $groups);
    }

    public function testMutationUserUpdate(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createUser (input: {name:"test_gql", email:"asd@mail.com", password:"asd"}) {
                id,
                name,
                created_at
              }
            }
        ');

        $user = $response->json('data.createUser');
        $this->assertEquals('test_gql', $user['name']);
        $this->assertDatabaseHas('users', [
            'name'  => 'test_gql',
            'email' => 'asd@mail.com'
        ]);

        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              updateUser (id: ' . $user['id'] . ', input: {name: "yabadabadoo"} ) {
                id,
                name,
                email
              }
            }
        ');

        $userUpdated = $response->json('data.updateUser');
        $this->assertEquals('yabadabadoo', $userUpdated['name']);
        $this->assertDatabaseHas('users', [
            'id'    => $user['id'],
            'name'  => $userUpdated['name'],
            'email' => $userUpdated['email']
        ]);
    }

    public function testMutationUserDelete(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createUser (input: {name:"test_gql", email:"asd@mail.com", password:"asd"}) {
                id,
                name,
                email,
                created_at
              }
            }
        ');

        $user = $response->json('data.createUser');
        $this->assertEquals('test_gql', $user['name']);
        $this->assertDatabaseHas('users', [
            'name'  => 'test_gql',
            'email' => 'asd@mail.com'
        ]);

        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              deleteUser (id: ' . $user['id'] . ') {
                id,
                name,
                email
              }
            }
        ');

        $userDeleted = $response->json('data.deleteUser');
        $this->assertEquals('test_gql', $userDeleted['name']);
        $this->assertDatabaseMissing('users', [
            'name'  => $user['name'],
            'email' => $user['email']
        ]);
    }

}
