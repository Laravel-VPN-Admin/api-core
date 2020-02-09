<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorizationControllerTest extends TestCase
{

    /**
     * @var \App\User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create([
            'name'     => 'Yan Gus',
            'email'    => 'Easter@egg.this',
            'password' => bcrypt('invalidcode')
        ]);

    }

    public function testUserCanLoginWithCorrectData() : void
    {
        $response = $this->post('/api/login', [
            'email'    => 'Easter@egg.this',
            'password' => 'invalidcode',
        ]);
        $this->assertEquals($response->json('token'), $this->user->api_token);
        $response->assertStatus(200);
    }

    public function testUserAuthorizationWithIncorrectData() : void
    {
        $response = $this->post('/api/login', [
            'email'    => 'test@test.ru',
            'password' => 'test',
        ]);
        $this->assertEquals($response->json('message'), 'User not found');
        $response->assertStatus(404);
    }

    public function testUserAuthorizationWithoutRequiredData() : void
    {
        $response = $this->post('/api/login', [
            'Hello' => 'World!'
        ]);
        $response->assertJson([
            'status' => false,
            "errors" => [
                'email'    => [
                    0 => "The email field is required."
                ],
                'password' => [
                    0 => "The password field is required."
                ]
            ]
        ]);
        $response->assertStatus(422);
    }

    public function testRefresh(): void
    {
        $response = $this->post('/api/refresh', [
            'api_token' => $this->user->api_token
        ]);
        dd($response->getContent());
        $this->assertEquals($response->json('token'), $this->user->api_token);
        $response->assertStatus(200);
    }
}
