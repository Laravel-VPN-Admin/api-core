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

    public function setUp(): void
    {
        parent::setUp();

        $this->log = factory(\App\Models\Log::class)->create([
            'code'      => 111111,
            'message'   => 'It\'s the job that\'s never started as takes longest to finish.',
            'server_id' => Server::query()->inRandomOrder()->first()->id,
            'user_id'   => User::query()->inRandomOrder()->first()->id,
        ]);
    }

    public function testQueryLogsGet(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                logs(orderBy: [ {field: "code", order: DESC} ], first: 200) {
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
        $this->assertDatabaseHas('logs', [
            'code'      => 111111,
            'message'   => 'It\'s the job that\'s never started as takes longest to finish.',
        ]);
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
