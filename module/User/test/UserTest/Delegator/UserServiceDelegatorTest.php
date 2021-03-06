<?php

namespace UserTest\Delegator;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use User\Adult;
use User\Delegator\UserServiceDelegator;
use User\Service\UserService;
use Zend\Db\Sql\Where;
use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\Paginator\Adapter\ArrayAdapter;

/**
 * Test UserServiceDelegatorTest
 *
 * @group User
 * @group Service
 * @group UserService
 * @group Delegator
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class UserServiceDelegatorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var \Mockery\MockInterface|\User\Service\UserService
     */
    protected $userService;

    /**
     * @var UserServiceDelegator
     */
    protected $delegator;

    /**
     * @var array
     */
    protected $calledEvents = [];

    /**
     * @var Adult
     */
    protected $user;

    /**
     * @before
     */
    public function setUpDelegator()
    {
        $this->calledEvents = [];
        $this->delegator    = new UserServiceDelegator($this->userService, new EventManager());
        $this->delegator->getEventManager()->attach('*', [$this, 'captureEvents'], 1000000);
    }

    /**
     * @before
     */
    public function setUpService()
    {
        $this->userService = \Mockery::mock(UserService::class);
    }

    /**
     * @before
     */
    public function setUpUser()
    {
        $this->user = new Adult();
        $this->user->setUserId(md5('foobar'));
        $this->user->setExternalId('foo-bar');
        $this->user->setEmail('chuck@manchuck.com');
        $this->user->setUserName('manchuck');
    }

    /**
     * @param Event $event
     */
    public function captureEvents(Event $event)
    {
        $this->calledEvents[] = [
            'name'   => $event->getName(),
            'target' => $event->getTarget(),
            'params' => $event->getParams()
        ];
    }

    /**
     * @test
     */
    public function testItShouldCallCreateUser()
    {
        $this->userService->shouldReceive('createUser')
            ->with($this->user)
            ->andReturn(true)
            ->once();

        $this->delegator->createUser($this->user);

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'save.new.user',
                'target' => $this->userService,
                'params' => ['user' => $this->user]
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'save.new.user.post',
                'target' => $this->userService,
                'params' => ['user' => $this->user, 'result' => true]
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallUpdateUser()
    {
        $this->userService->shouldReceive('updateUser')
            ->with($this->user)
            ->andReturn(true)
            ->once();


        $this->delegator->updateUser($this->user);

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'save.user',
                'target' => $this->userService,
                'params' => ['user' => $this->user]
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'save.user.post',
                'target' => $this->userService,
                'params' => ['user' => $this->user, 'result' => true]
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldNotCallCreateUserWhenEventPrevents()
    {
        $this->userService->shouldReceive('createUser')
            ->with($this->user)
            ->never();

        $this->delegator->getEventManager()->attach('save.new.user', function (Event $event) {
            $event->stopPropagation(true);
            return false;
        });

        $this->assertFalse($this->delegator->createUser($this->user));

        $this->assertEquals(1, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'save.new.user',
                'target' => $this->userService,
                'params' => ['user' => $this->user]
            ],
            $this->calledEvents[0]
        );
    }

    /**
     * @test
     */
    public function testItShouldNotCallUpdateUserWhenEventPrevents()
    {
        $this->userService->shouldReceive('UpdateUser')
            ->with($this->user)
            ->never();

        $this->delegator->getEventManager()->attach('save.user', function (Event $event) {
            $event->stopPropagation(true);
            return false;
        });

        $this->assertFalse($this->delegator->updateUser($this->user));

        $this->assertEquals(1, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'save.user',
                'target' => $this->userService,
                'params' => ['user' => $this->user]
            ],
            $this->calledEvents[0]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallFetchUser()
    {
        $this->userService->shouldReceive('fetchUser')
            ->with($this->user->getUserId(), null)
            ->andReturn($this->user)
            ->once();

        $this->assertSame(
            $this->user,
            $this->delegator->fetchUser($this->user->getUserId(), null)
        );

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.user',
                'target' => $this->userService,
                'params' => ['user_id' => $this->user->getUserId()]
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'fetch.user.post',
                'target' => $this->userService,
                'params' => ['user' => $this->user, 'user_id' => $this->user->getUserId()]
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallFetchUserByExternalId()
    {
        $this->userService->shouldReceive('fetchUserByExternalId')
            ->with($this->user->getExternalId())
            ->andReturn($this->user)
            ->once();

        $this->assertSame(
            $this->user,
            $this->delegator->fetchUserByExternalId($this->user->getExternalId())
        );

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.user.external',
                'target' => $this->userService,
                'params' => ['external_id' => $this->user->getExternalId()]
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'fetch.user.external.post',
                'target' => $this->userService,
                'params' => ['user' => $this->user, 'external_id' => $this->user->getExternalId()]
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallFetchUserByEmail()
    {
        $this->userService->shouldReceive('fetchUserByEmail')
            ->with($this->user->getEmail())
            ->andReturn($this->user)
            ->once();

        $this->assertSame(
            $this->user,
            $this->delegator->fetchUserByEmail($this->user->getEmail())
        );

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.user.email',
                'target' => $this->userService,
                'params' => ['email' => $this->user->getEmail()]
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'fetch.user.email.post',
                'target' => $this->userService,
                'params' => ['user' => $this->user, 'email' => $this->user->getEmail()]
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallFetchUserByUsername()
    {
        $this->userService->shouldReceive('fetchUserByUsername')
            ->with($this->user->getUserName())
            ->andReturn($this->user)
            ->once();

        $this->assertSame(
            $this->user,
            $this->delegator->fetchUserByUsername($this->user->getUserName())
        );

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.user.username',
                'target' => $this->userService,
                'params' => ['username' => $this->user->getUserName()]
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'fetch.user.username.post',
                'target' => $this->userService,
                'params' => ['user' => $this->user, 'username' => $this->user->getUserName()]
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldNotCallFetchUserAndReturnEventResult()
    {
        $this->userService->shouldReceive('fetchUser')
            ->with($this->user->getUserId())
            ->andReturn($this->user)
            ->never();

        $this->delegator->getEventManager()->attach('fetch.user', function (Event $event) {
            $event->stopPropagation(true);
            return $this->user;
        });

        $this->assertSame(
            $this->user,
            $this->delegator->fetchUser($this->user->getUserId(), null)
        );

        $this->assertEquals(1, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.user',
                'target' => $this->userService,
                'params' => ['user_id' => $this->user->getUserId()]
            ],
            $this->calledEvents[0]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallDeleteUser()
    {
        $this->userService->shouldReceive('deleteUser')
            ->with($this->user, true)
            ->andReturn(true)
            ->once();

        $this->assertTrue(
            $this->delegator->deleteUser($this->user)
        );

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'delete.user',
                'target' => $this->userService,
                'params' => ['user' => $this->user, 'soft' => true]
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'delete.user.post',
                'target' => $this->userService,
                'params' => ['user' => $this->user, 'soft' => true, 'result' => true]
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldNotCallDeleteUserAndReturnEventResult()
    {
        $this->userService->shouldReceive('deleteUser')
            ->with($this->user, true)
            ->andReturn(false)
            ->never();

        $this->delegator->getEventManager()->attach('delete.user', function (Event $event) {
            $event->stopPropagation(true);
            return false;
        });

        $this->assertFalse(
            $this->delegator->deleteUser($this->user)
        );

        $this->assertEquals(1, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'delete.user',
                'target' => $this->userService,
                'params' => ['user' => $this->user, 'soft' => true]
            ],
            $this->calledEvents[0]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallFetchAll()
    {
        $result = new ArrayAdapter([['foo' => 'bar']]);
        $this->userService->shouldReceive('fetchAll')
            ->andReturn($result)
            ->once();

        $this->assertSame(
            $result,
            $this->delegator->fetchAll()
        );

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.all.users',
                'target' => $this->userService,
                'params' => ['where' => new Where(), 'prototype' => null]
            ],
            $this->calledEvents[0]
        );

        $this->assertEquals(
            [
                'name'   => 'fetch.all.users.post',
                'target' => $this->userService,
                'params' => ['where' => new Where(), 'prototype' => null, 'users' => $result]
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallFetchAllWhenEventStops()
    {
        $result = new ArrayAdapter([['foo' => 'bar']]);
        $this->userService->shouldReceive('fetchAll')
            ->andReturn($result)
            ->never();

        $this->delegator->getEventManager()->attach('fetch.all.users', function (Event $event) use (&$result) {
            $event->stopPropagation(true);
            return $result;
        });

        $this->assertSame(
            $result,
            $this->delegator->fetchAll()
        );

        $this->assertEquals(1, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.all.users',
                'target' => $this->userService,
                'params' => ['where' => new Where(), 'prototype' => null]
            ],
            $this->calledEvents[0]
        );
    }
}
