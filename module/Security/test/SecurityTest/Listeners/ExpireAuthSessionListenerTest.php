<?php

namespace SecurityTest\Listeners;

use \PHPUnit_Framework_TestCase as TestCase;
use Zend\Session\Container;
use Zend\Session\SessionManager;

/**
 * Exception ExpireAuthSessionListenerTest
 */
class ExpireAuthSessionListenerTest extends TestCase
{
    protected $container;

    /**
     * @before
     */
    public function setUpContainer()
    {
        $this->markTestIncomplete('Not Set up');
        $manager     = new SessionManager();
        $this->container = new Container('expire_test', $manager);
    }

    public function testItShouldExpireSession()
    {

    }
}
