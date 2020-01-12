<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ServerGroup;
use Faker\Generator as Faker;

$factory->define(ServerGroup::class, function (Faker $faker) {
    return [
        'server_id' => \App\Models\Server::query()->inRandomOrder()->first()->id,
        'group_id'  => \App\Models\Group::query()->inRandomOrder()->first()->id,
    ];
});
