<?php

namespace Tests\Feature\Mutations;

use Tests\TestCase;

class ServersTest extends TestCase
{
    /**
     * @var \App\Models\Group
     */
    private $group;

    /**
     * @var \App\Models\Server
     */
    private $server;

    /**
     * @var \App\User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = factory(\App\Models\Group::class)->create([
            'name' => 'Lord of the Rings',
        ]);

        $this->server = factory(\App\Models\Server::class)->create([
            'hostname' => 'Isengard',
            'ipv4'     => '10.2.3.4',
            'ipv6'     => 'i:dd:qd',
            'token'    => 'token'
        ]);

        $this->user = factory(\App\User::class)->create([
            'name'     => 'Frodo Baggins',
            'email'    => 'frodo@bag.end',
            'password' => 'MyPrecious1'
        ]);

        $this->group->servers()->attach($this->server);
        $this->group->users()->attach($this->user);
    }

    public function testMutationServerCreate(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createServer (
                input: {
                  hostname:"Gondor",
                  ipv4:"127.0.0.2",
                  groups: {
                    connect: [' . $this->group->id . ']
                  }
                }
              )
              {
                id,
                hostname,
                ipv4,
                groups {
                  id,
                  name
                },
                users {
                  id,
                  name
                },
                created_at
              }
            }
        ');

        $server = $response->json('data.createServer');
        $this->assertEquals('Gondor', $server['hostname']);
        $this->assertDatabaseHas('servers', ['hostname' => 'Gondor', 'ipv4' => '127.0.0.2']);

        $groups = $response->json('data.createServer.groups');
        $this->assertContains(['name' => $this->group->name, 'id' => $this->group->id], $groups);

        $users = $response->json('data.createServer.users');
        $this->assertContains(['name' => $this->user->name, 'id' => $this->user->id], $users);
    }

    public function testMutationServerUpdate(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createServer (input: {hostname:"Gondor", ipv4:"127.0.0.2"}) {
                id,
                hostname,
                ipv4,
                created_at,
                updated_at
              }
            }
        ');

        $server = $response->json('data.createServer');
        $this->assertEquals('Gondor', $server['hostname']);
        $this->assertDatabaseHas('servers', ['hostname' => 'Gondor', 'ipv4' => '127.0.0.2']);

        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              updateServer (id: ' . $server['id'] . ', input: {hostname: "yabadabadoo"} ) {
                id,
                hostname,
                ipv4,
                created_at,
                updated_at
              }
            }
        ');

        $serverUpdated = $response->json('data.updateServer');
        $this->assertEquals('yabadabadoo', $serverUpdated['hostname']);
        $this->assertDatabaseHas('servers', ['id' => $server['id'], 'hostname' => $serverUpdated['hostname'], 'ipv4' => $serverUpdated['ipv4']]);
    }

    public function testMutationServerDelete(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createServer (input: {hostname:"Gondor", ipv4:"127.0.0.2"}) {
                id,
                hostname,
                ipv4,
                created_at,
                updated_at
              }
            }
        ');

        $server = $response->json('data.createServer');
        $this->assertEquals('Gondor', $server['hostname']);
        $this->assertDatabaseHas('servers', ['hostname' => 'Gondor', 'ipv4' => '127.0.0.2']);

        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              deleteServer (id: ' . $server['id'] . ') {
                id,
                hostname,
                ipv4
              }
            }
        ');

        $serverDeleted = $response->json('data.deleteServer');
        $this->assertEquals('Gondor', $serverDeleted['hostname']);
        $this->assertDatabaseMissing('servers', ['hostname' => $server['hostname'], 'ipv4' => $server['ipv4']]);
    }

}
