<?php

use Brisum\Lib\ObjectManager;

define('ABSPATH', __DIR__);

require ABSPATH . '/config/parameters.php';
require ABSPATH . '/vendor/autoload.php';

if (session_id() == false) {
    ini_set('session.use_only_cookies', 'On');
    ini_set('session.use_trans_sid', 'Off');
    ini_set('session.cookie_httponly', 'On');

    session_set_cookie_params(0, '/');
    session_start();
}

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
