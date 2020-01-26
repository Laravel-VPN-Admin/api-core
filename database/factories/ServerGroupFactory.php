<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ServerGroup;
use Faker\Generator as Faker;

$factory->define(ServerGroup::class, function (Faker $faker) {

    $server_id = \App\Models\Server::query()->inRandomOrder()->first()->id;
    $group_id  = \App\Models\Group::query()->inRandomOrder()->first()->id;

    return [
        'server_id' => $server_id,
        'group_id'  => $group_id,
    ];
});
