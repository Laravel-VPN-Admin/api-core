<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => \Hash::make('password'), // password
        'api_token'         => \Str::random(80),
        'remember_token'    => \Str::random(10),
        'object'            => null,
    ];
});
