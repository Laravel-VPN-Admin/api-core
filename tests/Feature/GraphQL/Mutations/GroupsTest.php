<?php

namespace Tests\Feature\Mutations;

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

    public function testMutationGroupCreate(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createGroup (input: {name:"Wizard"}) {
                id,
                name,
                created_at
              }
            }
        ');

        $group = $response->json('data.createGroup');
        $this->assertEquals('Wizard', $group['name']);
        $this->assertDatabaseHas('groups', ['name' => 'Wizard']);
    }

    public function testMutationGroupUpdate(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createGroup (input: {name:"Wizard"}) {
                id,
                name,
                created_at
              }
            }
        ');

        $group = $response->json('data.createGroup');
        $this->assertEquals('Wizard', $group['name']);
        $this->assertDatabaseHas('groups', ['name' => 'Wizard']);

        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              updateGroup (id: ' . $group['id'] . ', input: {name: "Undead"} ) {
                id,
                name,
                created_at
              }
            }
        ');

        $groupUpdated = $response->json('data.updateGroup');
        $this->assertEquals('Undead', $groupUpdated['name']);
        $this->assertDatabaseHas('groups', ['id' => $group['id'], 'name' => $groupUpdated['name']]);
    }

    public function testMutationGroupDelete(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              createGroup (input: {name:"Wizard"}) {
                id,
                name,
                created_at
              }
            }
        ');

        $group = $response->json('data.createGroup');
        $this->assertEquals('Wizard', $group['name']);
        $this->assertDatabaseHas('groups', ['name' => 'Wizard']);

        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
             mutation {
              deleteGroup (id: ' . $group['id'] . ') {
                id,
                name,
                created_at
              }
            }
        ');

        $groupDeleted = $response->json('data.deleteGroup');
        $this->assertEquals('Wizard', $groupDeleted['name']);
        $this->assertDatabaseMissing('groups', ['name' => $group['name']]);
    }

}
