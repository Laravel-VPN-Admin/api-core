<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Configuration;
use App\Models\Server;
use Faker\Generator as Faker;

$factory->define(Server::class, static function (Faker $faker) {
    /** @var \App\Models\Configuration $configuration */
    $configuration = factory(Configuration::class)->create();

    return [
        'hostname'         => $faker->domainName,
        'ipv4'             => $faker->ipv4,
        'ipv6'             => $faker->ipv6,
        'configuration_id' => $configuration->id,
    ];
});
