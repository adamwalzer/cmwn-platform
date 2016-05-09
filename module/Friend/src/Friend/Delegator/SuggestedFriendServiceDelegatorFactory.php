<?php

namespace Friend\Delegator;

use Friend\Service\SuggestedFriendService;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SuggestedFriendServiceDelegatorFactory
 */
class SuggestedFriendServiceDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * A factory that creates delegates of a given service
     *
     * @param ServiceLocatorInterface $serviceLocator the service locator which requested the service
     * @param string $name the normalized service name
     * @param string $requestedName the requested service name
     * @param callable $callback the callback that is responsible for creating the service
     *
     * @return mixed
     */
    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        /** @var SuggestedFriendService $realService */
        $realService = call_user_func($callback);
        return new SuggestedFriendServiceDelegator($realService);
    }
}