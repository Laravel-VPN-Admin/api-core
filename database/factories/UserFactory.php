<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => \Hash::make('password'), // password
        'api_token'         => \Hash::make(\Str::random(80)),
        'remember_token'    => \Str::random(10),
        'object'            => null,
    ];
});
