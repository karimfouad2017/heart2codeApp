<?php

use Faker\Generator as Faker;
use OpenDialogAi\Core\Components\Configuration\ComponentConfiguration;

$factory->define(ComponentConfiguration::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->words(3, true),
        'scenario_id' => '0x000',
        'component_id' => 'interpreter.core.callbackInterpreter',
        'configuration' => [
            'callbacks' => [
                'WELCOME' => 'intent.core.welcome',
            ],
        ],
    ];
});
