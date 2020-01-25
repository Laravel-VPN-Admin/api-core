<?php

namespace Tests\Feature\Queries;

use Tests\TestCase;

class ServersTest extends TestCase
{
    /**
     * @var \App\Models\Server
     */
    private $server;

    public function setUp(): void
    {
        parent::setUp();

        $this->server = factory(\App\Models\Server::class)->create([
            'hostname' => 'vpn-openvpn-1',
            'ipv4'     => '1.2.3.4',
            'ipv6'     => 'i:dd:qd',
            'token'    => 'token'
        ]);
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
            'hostname' => 'vpn-openvpn-1',
            'ipv4'     => '1.2.3.4',
            'ipv6'     => 'i:dd:qd',
            'token'    => 'token'
        ]);
        $this->assertContains('vpn-openvpn-1', $names);
    }

    public function testQueryServerGet(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                server(id: ' . $this->server->id . ') {
                    id,
                    hostname
                }
            }
        ');

        $server = $response->json('data.server');
        $this->assertEquals('vpn-openvpn-1', $server['hostname']);
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
