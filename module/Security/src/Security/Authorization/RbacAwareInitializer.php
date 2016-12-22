<?php

namespace Security\Authorization;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Initializer\InitializerInterface;

/**
 * Class RbacAwareInitializer
 */
class RbacAwareInitializer implements InitializerInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $instance)
    {
        if (!$instance instanceof RbacAwareInterface) {
            return;
        }

        $instance->setRbac($container->get(Rbac::class));
    }
}
