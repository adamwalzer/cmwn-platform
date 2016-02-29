<?php

return [
    'service_manager' => [
        'aliases' => [
            'Org\Service'          => 'Org\Service\OrganizationService',
            'Organization\Service' => 'Org\Service\OrganizationService'
        ],
        'invokables' => [
            'Org\Delegator\OrganizationDelegatorFactory'
        ],
        'factories' => [
            'Org\Service\OrganizationService' => 'Org\Service\OrganizationServiceFactory'
        ],
        'delegators' => [
            'Org\Service\OrganizationService' => [
                'Org\Delegator\OrganizationDelegatorFactory'
            ],
        ],
    ],
];
