<?php

return [
    'rules' => [
        'aliases'   => [
            \Rule\Rule\Collection\RuleCollectionInterface::class => \Rule\Rule\Collection\RuleCollection::class,
        ],
        'factories' => [
            \Rule\Rule\Basic\AlwaysSatisfiedRule::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Rule\Rule\Basic\NeverSatisfiedRule::class  => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Rule\Rule\Basic\AndRule::class             => \Rule\Rule\Service\BuildDependantRuleFactory::class,
            \Rule\Rule\Basic\NotRule::class             => \Rule\Rule\Service\BuildDependantRuleFactory::class,
            \Rule\Rule\Basic\EitherRule::class          => \Rule\Rule\Service\BuildDependantRuleFactory::class,
            \Rule\Rule\Collection\RuleCollection::class => \Rule\Rule\Service\BuildRuleCollectionFactory::class,
            \Rule\Rule\Object\IsTypeRule::class         => \Rule\Rule\Service\BuildRuleFactory::class,
            \Rule\Event\Rule\EventParamMatches::class   => \Rule\Rule\Service\BuildRuleFactory::class,
        ],
        'shared'    => [
            \Rule\Rule\Basic\AlwaysSatisfiedRule::class => true,
            \Rule\Rule\Basic\NeverSatisfiedRule::class  => true,
            \Rule\Rule\Collection\RuleCollection::class => false,
            \Rule\Rule\Basic\AndRule::class             => false,
            \Rule\Rule\Basic\NotRule::class             => false,
            \Rule\Rule\Basic\EitherRule::class          => false,
            \Rule\Rule\Object\IsTypeRule::class         => false,
            \Rule\Event\Rule\EventParamMatches::class   => false,
        ],
    ],

    'providers' => [
        'aliases'            => [
            \Rule\Provider\Collection\ProviderCollectionInterface::class =>
                \Rule\Provider\Collection\ProviderCollection::class,
        ],
        'factories'          => [
            \Rule\Provider\BasicValueProvider::class            => \Rule\Provider\Service\BuildProviderFactory::class,
            \Rule\Provider\Collection\ProviderCollection::class =>
                \Rule\Provider\Service\BuildProviderCollectionFactory::class,
            \Rule\Event\Provider\FromEventTargetProvider::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Rule\Event\Provider\EventProvider::class           => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Rule\Event\Provider\FromEventParamProvider::class  => \Rule\Provider\Service\BuildProviderFactory::class,
        ],
        'abstract_factories' => [
            \Rule\Provider\Service\BuildProviderFromConfigFactory::class =>
                \Rule\Provider\Service\BuildProviderFromConfigFactory::class,
        ],
        'shared'             => [
            \Rule\Provider\Collection\ProviderCollection::class => false,
            \Rule\Provider\BasicValueProvider::class            => false,
            \Rule\Event\Provider\EventProvider::class           => false,
        ],
    ],

    'actions' => [
        'aliases'            => [
            \Rule\Action\Collection\ActionCollectionInterface::class => \Rule\Action\Collection\ActionCollection::class,
        ],
        'factories'          => [
            \Rule\Event\Action\SetEventParamAction::class   => \Rule\Action\Service\BuildActionFactory::class,
            \Rule\Action\NoopAction::class                  => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Rule\Action\Collection\ActionCollection::class => \Rule\Action\Service\BuildActionCollectionFactory::class,
        ],
        'shared'             => [
            \Rule\Action\Collection\ActionCollection::class => false,
            \Rule\Event\Action\SetEventParamAction::class   => false,
        ],
        'abstract_factories' => [
            \Rule\Action\Service\BuildActionFromConfigFactory::class =>
                \Rule\Action\Service\BuildActionFromConfigFactory::class,
        ],
    ],

    'specifications' => [
        'aliases'            => [
            \Rule\Engine\Specification\SpecificationCollectionInterface::class =>
                \Rule\Engine\Specification\SpecificationCollection::class,
        ],
        'factories'          => [
            \Rule\Engine\Specification\ArraySpecification::class      =>
                \Rule\Engine\Service\BuildSpecificationFromConfigFactory::class,
            \Rule\Engine\Specification\SpecificationCollection::class =>
                \Rule\Engine\Service\BuildSpecificationCollectionFactory::class,
            'AllSpecifications'                                       =>
                \Rule\Engine\Service\SpecificationCollectionFactory::class,
            \Rule\Engine\Specification\EngineSpecification::class     =>
                \Rule\Engine\Service\BuildSpecificationFromConfigFactory::class,
        ],
        'shared'             => [
            \Rule\Engine\Specification\EngineSpecification::class => false,
            \Rule\Engine\Specification\ArraySpecification::class  => false,
        ],
        'abstract_factories' => [
            \Rule\Engine\Service\BuildSpecificationFromConfigFactory::class =>
                \Rule\Engine\Service\BuildSpecificationFromConfigFactory::class,
        ],
    ],

    'service_manager' => [
        'aliases'   => [
            'ActionManager'        => \Rule\Action\Service\ActionManager::class,
            'ProviderManager'      => \Rule\Provider\Service\ProviderManager::class,
            'RuleManager'          => \Rule\Rule\Service\RuleManager::class,
            'SpecificationManager' => \Rule\Engine\Service\SpecificationManager::class,
        ],
        'factories' => [
            \Rule\Action\Service\ActionManager::class        => \Rule\Action\Service\ActionManagerFactory::class,
            \Rule\Provider\Service\ProviderManager::class    => \Rule\Provider\Service\ProviderManagerFactory::class,
            \Rule\Rule\Service\RuleManager::class            => \Rule\Rule\Service\RuleManagerFactory::class,
            \Rule\Engine\Service\SpecificationManager::class => \Rule\Engine\Service\SpecificationManagerFactory::class,
            \Rule\Engine\Engine::class                       => \Rule\Engine\Service\EngineFactory::class,
        ],
    ],
];
