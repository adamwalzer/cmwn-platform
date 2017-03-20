<?php

return [
    \Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory::class => [
        \Feed\Service\FeedService::class => ['Table/Feed'],
        \Feed\Service\FeedUserService::class => ['Table/UserFeed'],
        \Feed\Listener\InjectFeedListener::class => [
            \Feed\Service\FeedServiceInterface::class,
            \Feed\Service\FeedUserServiceInterface::class,
            \Friend\Service\FriendServiceInterface::class,
        ],
    ],
    'shared-listeners' => [
        'Feed\Listener\InjectFeedListener' => \Feed\Listener\InjectFeedListener::class
    ],
    'service_manager' => [
        'aliases' => [
            \Feed\Service\FeedServiceInterface::class => \Feed\Service\FeedService::class,
            \Feed\Service\FeedUserServiceInterface::class => \Feed\Service\FeedUserService::class,
        ],
        'delegators' => [
            \Feed\Service\FeedService::class => [
                \Feed\Delegator\FeedDelegatorFactory::class
            ],
            \Feed\Service\FeedUserService::class => [
                \Feed\Delegator\FeedUserDelegatorFactory::class
            ]
        ]
    ],
];
