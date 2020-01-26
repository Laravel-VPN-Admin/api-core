<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserGroup;
use Faker\Generator as Faker;

$factory->define(UserGroup::class, function (Faker $faker) {

    $user_id  = \App\User::query()->inRandomOrder()->first()->id;
    $group_id = \App\Models\Group::query()->inRandomOrder()->first()->id;

    return [
        'user_id'  => $user_id,
        'group_id' => $group_id,
    ];
});
