<?php

namespace Tests\Feature\GraphQL\Mutations;

use App\Models\Group;
use App\Models\User;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * @var \App\Models\Group
     */
    private $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'name'      => 'Frodo Baggins',
            'email'     => 'frodo@bag.end',
            'password'  => \Hash::make('MyPrecious1'),
            'api_token' => 'some_random_token',
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'Accept'        => 'application/json',
        ]);

        $this->group = factory(Group::class)->create([
            'name' => 'Lord of the Rings',
        ]);
    }

    public function testMutationUserLogin(): void
    {
        $this->flushHeaders();

        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              login (
                input: {
                  email:"frodo@bag.end",
                  password:"MyPrecious1",
                }
              )
              {
                id
                api_token
              }
            }
        ');

        $user = $response->json('data.login');
        $this->assertNotEmpty($user['api_token']);
    }

    public function testMutationUserRefresh(): void
    {
        $this->flushHeaders();

        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              login (
                input: {
                  email:"frodo@bag.end",
                  password:"MyPrecious1",
                }
              )
              {
                id
                api_token
              }
            }
        ');

        $user = $response->json('data.login');
        $this->assertNotEmpty($user['api_token']);

        /** @var \Illuminate\Testing\TestResponse $response */
        $response2 = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $user['api_token'],
                'Accept'        => 'application/json',
            ])
            ->graphQL(/** @lang GraphQL */ '
                 mutation {
                  refresh {
                    id
                    api_token
                  }
                }
            ');

        $user2 = $response2->json('data.refresh');
        $this->assertNotEquals($user['api_token'], $user2['api_token']);
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
                  password:"asdasdasd",
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
              createUser (input: {name:"test_gql", email:"asd@mail.com", password:"asdasdasd"}) {
                id
                name
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
                id
                name
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
              createUser (input: {name:"test_gql", email:"asd@mail.com", password:"asdasdasd"}) {
                id
                name
                email
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
                id
                name
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
