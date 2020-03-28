<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\JsonResponse;
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
            'name'  => 'Yan Gus',
            'email' => 'Easter@egg.this'
        ]);
    }

    public function testUserCanLoginWithCorrectData(): void
    {
        $response = $this->post(route('api.login'), [
            'email'    => 'Easter@egg.this',
            'password' => 'password',
        ]);
        $this->assertEquals($response->json('token'), $this->user->api_token);
        $response->assertOk();
    }

    public function testUserAuthorizationWithIncorrectData(): void
    {
        $response = $this->post(route('api.login'), [
            'email'    => 'test@test.ru',
            'password' => 'test',
        ]);
        $this->assertEquals($response->json('message'), 'User not found');
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
    }

    public function testUserAuthorizationWithoutRequiredData(): void
    {
        $response = $this->post(route('api.login'), [
            'Hello' => 'World!'
        ]);
        $response->assertJson([
            'status' => false,
            'errors' => [
                'email'    => [
                    'The email field is required.'
                ],
                'password' => [
                    'The password field is required.'
                ]
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

//    public function testMe(): void
//    {
//        $response = $this->get(route('api.me'), [
//            'Authorization' => 'Bearer ' . $this->user->api_token,
//            'Accept'        => 'application/json',
//        ]);
//
//        $this->assertEquals($response->json('id'), $this->user->id);
//        $response->assertOk();
//    }

//    public function testRefresh(): void
//    {
//        $response = $this->post(route('api.refresh'), [], [
//            'Authorization' => 'Bearer ' . $this->user->api_token,
//            'Accept'        => 'application/json',
//        ]);
//        $this->user->refresh();
//        $this->assertEquals($response->json('token'), $this->user->api_token);
//        $response->assertOk();
//    }
}
