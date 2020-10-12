<?php

namespace Tests\Feature\GraphQL\Queries;

use Tests\TestCase;

class GroupsTest extends TestCase
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

    public function testQueryGroupsGet(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                groups(orderBy: [ {field: NAME, order: DESC} ], first: 30) {
                    data {
                        id,
                        name
                    }
                }
            }
        ');

        $names = $response->json('data.*.data.*.name');
        $this->assertDatabaseHas('groups', [
            'name' => 'Lord of the Rings',
        ]);
        $this->assertContains('Lord of the Rings', $names);
    }

    public function testQueryGroupGet(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                group(id: ' . $this->group->id . ') {
                    id,
                    name,
                    servers {
                        hostname,
                        ipv4
                    },
                    users {
                        name,
                        email
                    }
                }
            }
        ');

        $group   = $response->json('data.group');
        $servers = $response->json('data.group.servers');
        $users   = $response->json('data.group.users');

        $this->assertEquals('Lord of the Rings', $group['name']);
        $this->assertContains(['hostname' => 'Isengard', 'ipv4' => '10.2.3.4'], $servers);
        $this->assertContains(['name' => 'Frodo Baggins', 'email' => 'frodo@bag.end'], $users);
    }

    public function testQueryGroupGetError(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                group(id: ' . ($this->group->id + 1) . ') {
                    id,
                    hostname
                }
            }
        ');

        $group = $response->json('data.group');
        $this->assertNull($group);
    }

}
