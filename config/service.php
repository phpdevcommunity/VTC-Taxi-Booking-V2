<?php

use Fady\Routing\Router;
use App\Routes;
use App\Session\SessionManager;
use App\Session\SessionInterface;
use Webbym\DependencyInjection\Container;
use Psr\Container\ContainerInterface;
use App\Model\DataBase;


return [
    Router::class => [
        'arguments' => [
            Routes::class
        ]
    ],
    \Twig_Loader_Filesystem::class => [
        'arguments' => [
            'view'
        ]
    ],
    \Twig_Environment::class => [
        'arguments' => [
            Twig_Loader_Filesystem::class,
            [
                'cache' => false,
                'debug' => true,
                'strict_variables' => true,
            ]
        ]
    ],
    SessionInterface::class => [
        'class' => SessionManager::class
    ],
    ContainerInterface::class => [
        'class' => Container::class
    ],
    \PDO::class => [
        'class' => DataBase::class,
        'arguments' => [
            '%database.host%',
            '%database.name%',
            '%database.port%',
            '%database.user%',
            '%database.password%',
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        ]
    ]

];