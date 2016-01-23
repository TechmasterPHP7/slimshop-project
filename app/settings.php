<?php
return [
    'settings' => [
        'displayErrorDetails' => true,
        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig' => [
                'cache' => __DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // doctrine settings
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    __DIR__ . '/src/models'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' =>  __DIR__.'/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver'   => 'pdo_pgsql',
                'host'     => 'localhost',
                'port'     => 5432,
<<<<<<< HEAD
                'dbname'   => 'shopper',
                'user'     => 'postgres',
                'password' => '240315',
=======
                'dbname'   => 'vaynu',
                'user'     => 'vhchung',
                'password' => '',
>>>>>>> 4fa50dea05b6f6022a59f4d4c6487ad3d556ef9b
            ]
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
        ],
    ],
];
