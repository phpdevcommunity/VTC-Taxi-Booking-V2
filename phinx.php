<?php

require __DIR__ . '/index.php';

$container = \Webbym\DependencyInjection\Container::getContainer();

return [
    'paths' => [
        'migrations' => __DIR__ . '/config/migrations',
        'seeds' => __DIR__. '/config/seeds'
    ],
    'environments' => [
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $container->getParameter('database.host'),
            'name' => $container->getParameter('database.name'),
            'user' => $container->getParameter('database.user'),
            'pass' => $container->getParameter('database.password')
        ]
    ]

];