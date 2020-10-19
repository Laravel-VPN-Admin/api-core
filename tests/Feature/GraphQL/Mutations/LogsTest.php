<?php

namespace Tests\Feature\GraphQL\Mutations;

use App\Models\Server;
use App\Models\User;
use Tests\TestCase;

class LogsTest extends TestCase
{
    /**
     * @var \App\Models\Server
     */
    private $server;

    /**
     * @var \App\Models\User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->server = factory(Server::class)->create([
            'hostname' => 'Isengard',
            'ipv4'     => '10.2.3.4',
            'ipv6'     => 'i:dd:qd',
        ]);

        $this->user = factory(User::class)->create([
            'name'     => 'Frodo Baggins',
            'email'    => 'frodo@bag.end',
            'password' => \Hash::make('MyPrecious1')
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'Accept'        => 'application/json',
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogCreate()
    {
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createLog (
                input: {
                  code:100
                  message:"Test message for pusher"
                  user_id:' . $this->user->id . '
                  server_id:' . $this->server->id . '
                }
              )
              {
                id
                message
                user {
                  id
                  name
                }
                server {
                  id
                  hostname
                }
              }
            }
        ');

        $log = $response->json('data.createLog');

        $this->assertEquals('Test message for pusher', $log['message']);
        $this->assertDatabaseHas('logs', ['id' => $log['id']]);
    }
}
