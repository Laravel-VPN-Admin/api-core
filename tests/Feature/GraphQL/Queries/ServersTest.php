<?php

namespace Tests\Feature\Queries;

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

        $this->server->groups()->attach($this->group);
    }

    public function testQueryServersGet(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                servers(orderBy: [ {field: "hostname", order: DESC} ], first: 20) {
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
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                server(id: ' . $this->server->id . ') {
                    id,
                    hostname,
                    groups {
                        name
                    }
                }
            }
        ');

        $server = $response->json('data.server');
        $groups = $response->json('data.server.groups');

        $this->assertEquals('Isengard', $server['hostname']);
        $this->assertContains(['name' => 'Lord of the Rings'], $groups);
    }

    public function testQueryServerGetError(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
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
