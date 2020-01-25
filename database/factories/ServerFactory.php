<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server;
use Faker\Generator as Faker;

$factory->define(Server::class, function (Faker $faker) {
    return [
        'hostname' => $faker->domainName,
        'ipv4'     => $faker->ipv4,
        'ipv6'     => $faker->ipv6,
        'token'    => $faker->md5,
    ];
});
