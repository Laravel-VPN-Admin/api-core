<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Log;
use Faker\Generator as Faker;

$factory->define(\App\Models\UserGroup::class, function (Faker $faker) {
    return [
        'user_id'  => \App\User::query()->inRandomOrder()->first()->id,
        'group_id' => \App\Models\Group::query()->inRandomOrder()->first()->id,
    ];
});
