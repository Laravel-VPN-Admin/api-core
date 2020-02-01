<?php

namespace Tests\Feature\Mutations;

use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    /**
     * @var \App\User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
    }

    public function testMutationLoginUser(): void
    {
        /** @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response = $this->graphQL(/** @lang GraphQL */ '
            mutation {
              login(input: { username: "' . $this->user->email . '", password: "password" }) {
                user {
                  email
                }
                access_token
                refresh_token
                expires_in
              }
            }
        ');

        $user = $response->json('data.login.user');
        $this->assertEquals($this->user->email, $user['email']);
        $this->assertDatabaseHas('users', ['email' => $user['email']]);
    }

}
