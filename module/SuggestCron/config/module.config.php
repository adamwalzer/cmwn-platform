<?php

return [
    'controllers' => [
        'factories' => [
            'SuggestCron\Controller' => \SuggestCron\Controller\SuggestCronControllerFactory::class,
        ],
    ],

    'console' => [
        'router' => [
            'routes' => [
                'suggest-cron' => [
                    'options' => [
                        'route'    => 'cron:suggest [--verbose|-v] [--debug|-d]',
                        'defaults' => [
                            'controller' => 'SuggestCron\Controller',
                            'action'     => 'suggestCron',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
