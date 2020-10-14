<?php

namespace Tests\Feature\GraphQL\Queries;

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
        ]);

        $this->user = factory(\App\User::class)->create([
            'name'     => 'Frodo Baggins',
            'email'    => 'frodo@bag.end',
            'password' => \Hash::make('MyPrecious1')
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'Accept'        => 'application/json',
        ]);

        $this->group->servers()->attach($this->server);
        $this->group->users()->attach($this->user);
    }

    public function testQueryServersGet(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                servers(orderBy: [ {field: HOSTNAME, order: DESC} ], first: 20) {
                    data {
                        id,
                        hostname
                    }
                }
            }
        ');

        $names = $response->json('data.*.data.*.hostname');
        $this->assertDatabaseHas('servers', [
            'hostname' => 'Isengard',
            'ipv4'     => '10.2.3.4',
            'ipv6'     => 'i:dd:qd',
            'token'    => 'token'
        ]);
        $this->assertContains('Isengard', $names);
    }

    public function testQueryServerGet(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                server(id: ' . $this->server->id . ') {
                    id,
                    hostname,
                    groups {
                        name
                    },
                    users {
                        name
                    }
                }
            }
        ');

        $server = $response->json('data.server');
        $this->assertEquals('Isengard', $server['hostname']);

        $groups = $response->json('data.server.groups');
        $this->assertContains(['name' => 'Lord of the Rings'], $groups);

        $users = $response->json('data.server.users');
        $this->assertContains(['name' => 'Frodo Baggins'], $users);
    }

    public function testQueryServerGetError(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                server(id: ' . ($this->server->id + 1) . ') {
                    id,
                    hostname
                }
            }
        ');

        $server = $response->json('data.server');
        $this->assertNull($server);
    }

}
