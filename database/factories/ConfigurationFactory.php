<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Configuration;
use Faker\Generator as Faker;

$factory->define(Configuration::class, static function (Faker $faker) {
    $type    = $faker->randomKey(Configuration::TYPES);
    $options = [];

    if ($type === Configuration::TYPE_OPENVPN) {
        $options = [
            'parameters' => [
                'dev'  => 'tun',
                'port' => 1194
            ]
        ];
    }

    if ($type === Configuration::TYPE_XL2TP) {
        $options = [
            'global' => [
                'listen-addr' => '127.0.0.1',
                'port'        => 1701
            ]
        ];
    }

    return [
        'options' => $options,
        'type_id' => $type,
    ];
});
