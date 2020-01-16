<?php

use Brisum\Lib\ObjectManager;

define('ABSPATH', __DIR__);

require ABSPATH . '/vendor/autoload.php';

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
        ],
        'App\Utils\Task\TaskService' => ['shared' => true]
    ],
];
$sharedInstances = [
    // pass
];

$objectManager = new ObjectManager($config, $sharedInstances);
ObjectManager::setInstance($objectManager);
