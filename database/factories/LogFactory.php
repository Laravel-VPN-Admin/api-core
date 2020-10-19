<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Log;
use App\Models\Server;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    /** @var \App\Models\User $user */
    $user = factory(User::class)->create();

    /** @var \App\Models\Server $server */
    $server = factory(Server::class)->create();

    return [
        'message'   => $faker->sentence(),
        'code'      => $faker->numberBetween(100, 200),
        'server_id' => $server->id,
        'user_id'   => $user->id,
    ];
});
