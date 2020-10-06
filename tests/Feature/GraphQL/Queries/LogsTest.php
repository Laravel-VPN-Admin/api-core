<?php

namespace Tests\Feature\GraphQL\Queries;

use App\Models\Server;
use App\User;
use Tests\TestCase;

class LogsTest extends TestCase
{
    /**
     * @var \App\Models\Log
     */
    private $log;

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

        $this->log = factory(\App\Models\Log::class)->create([
            'code'      => 111111,
            'message'   => 'It\'s the job that\'s never started as takes longest to finish.',
            'server_id' => $this->server->id,
            'user_id'   => $this->user->id,
        ]);
    }

    public function testQueryLogsGet(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                logs(orderBy: [ {field: CODE, order: DESC} ], first: 200) {
                    data {
                        id,
                        code,
                        message,
                        user {
                            id,
                            name
                        },
                        server {
                            id,
                            hostname,
                            ipv4
                            ipv4
                        }
                    }
                }
            }
        ');
        $codes = $response->json('data.*.data.*.code');
        $this->assertContains(111111, $codes);
    }

    public function testQueryLogGet(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                log(id: ' . $this->log->id . ') {
                    id,
                    code,
                    message,
                    user {
                        id,
                        name
                    },
                    server {
                        id,
                        hostname,
                        ipv4
                    }
                }
            }
        ');

        $log = $response->json('data.log');
        $this->assertEquals(111111, $log['code']);
    }

    public function testQueryLogGetError(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                log(id: ' . ($this->log->id + 1) . ') {
                    id,
                    code,
                    message,
                    user {
                        id,
                        name
                    },
                    server {
                        id,
                        hostname,
                        ipv4
                    }
                }
            }
        ');

        $log = $response->json('data.log');
        $this->assertNull($log);
    }

}
