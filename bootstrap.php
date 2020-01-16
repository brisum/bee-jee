<?php

use Brisum\Lib\ObjectManager;

define('ABSPATH', __DIR__);

$autoload = require(ABSPATH . '/vendor/autoload.php');

$config = [
    'preference' => [],
    'virtualType' => [],
    'type' => [
        'App\Utils\RouteService' => ['shared' => true],
        'App\Utils\Doctrine\DoctrineService' => [
            'shared' => true,
            'arguments' => [
                'paths' => [
                    'value' => [
                        ABSPATH . '/src/Entity'
                    ]
                ],
                'isDevMode' => [
                    'value' => false
                ]
            ]
        ],
        'App\Utils\View' => [
            'shared' => true,
            'arguments' => [
                'dirTemplate' => [
                    'value' => ABSPATH . '/src/Template'
                ]
            ]
        ]
    ],
];
$sharedInstances = [
    // pass
];

$objectManager = new ObjectManager($config, $sharedInstances);
ObjectManager::setInstance($objectManager);