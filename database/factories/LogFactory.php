<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Log;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    return [
        'message'   => $faker->sentence(),
        'code'      => $faker->numberBetween(100, 200),
        'server_id' => \App\Models\Server::query()->inRandomOrder()->first()->id,
        'user_id'   => \App\User::query()->inRandomOrder()->first()->id,
    ];
});
