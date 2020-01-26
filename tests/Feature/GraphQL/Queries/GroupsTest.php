<?php

namespace Tests\Feature\Queries;

use Tests\TestCase;

class GroupsTest extends TestCase
{
    /**
     * @var \App\Models\Group
     */
    private $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = factory(\App\Models\Group::class)->create([
            'name' => 'Lord of the Rings',
        ]);
    }

    public function testQueryGroupsGet(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                groups(orderBy: [ {field: "name", order: DESC} ], first: 30) {
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
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            {
                group(id: ' . $this->group->id . ') {
                    id,
                    name
                }
            }
        ');

        $group = $response->json('data.group');
        $this->assertEquals('Lord of the Rings', $group['name']);
    }

    public function testQueryGroupGetError(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
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