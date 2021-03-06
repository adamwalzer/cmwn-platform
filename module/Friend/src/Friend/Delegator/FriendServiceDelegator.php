<?php

namespace Friend\Delegator;

use Application\Utils\ServiceTrait;
use Friend\Service\FriendService;
use Friend\Service\FriendServiceInterface;
use User\UserInterface;
use Zend\Db\Sql\Predicate\PredicateInterface;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\Paginator\Adapter\DbSelect;

/**
 * Class FriendServiceDelegator
 */
class FriendServiceDelegator implements FriendServiceInterface, EventManagerAwareInterface
{
    use ServiceTrait;
    use EventManagerAwareTrait;

    /**
     * @var array Adds the Importer interface the shared manager
     */
    protected $eventIdentifier = [FriendServiceInterface::class];

    /**
     * @var FriendService
     */
    protected $realService;

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * FriendServiceDelegator constructor.
     * @param FriendService $realService
     * @param EventManagerInterface $events
     */
    public function __construct(FriendService $realService, EventManagerInterface $events)
    {
        $this->realService = $realService;
        $this->events      = $events;
        $events->addIdentifiers(array_merge(
            [FriendServiceInterface::class, static::class, FriendService::class],
            $events->getIdentifiers()
        ));
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->events;
    }

    /**
     * Fetches all the friends for a user
     *
     * @param string|UserInterface $user
     * @param null|array|PredicateInterface $where
     * @param null|UserInterface|object $prototype
     * @throws \Exception
     * @return DbSelect
     */
    public function fetchFriendsForUser($user, $where = null, $prototype = null)
    {
        $eventParams = ['user' => $user, 'where' => $where, 'prototype' => $prototype];
        $event       = new Event('fetch.all.friends', $this->realService, $eventParams);
        $response    = $this->getEventManager()->triggerEvent($event);
        if ($response->stopped()) {
            return $response->last();
        }

        try {
            $return = $this->realService->fetchFriendsForUser($user, $where, $prototype);
            $event->setParam('result', $return);
            $event->setName('fetch.all.friends.post');
        } catch (\Exception $exception) {
            $event->setParam('exception', $exception);
            $event->setName('fetch.all.friends.error');
            $this->getEventManager()->triggerEvent($event);
            throw $exception;
        }

        $this->getEventManager()->triggerEvent($event);
        return $return;
    }

    /**
     * Adds a friend to a user
     *
     * @param string|UserInterface $user
     * @param string|UserInterface $friend
     * @throws \Exception
     * @return bool
     */
    public function attachFriendToUser($user, $friend)
    {
        $eventParams = ['user' => $user, 'friend' => $friend];
        $event       = new Event('attach.friend', $this->realService, $eventParams);
        $response    = $this->getEventManager()->triggerEvent($event);
        if ($response->stopped()) {
            return $response->last();
        }

        try {
            $return = $this->realService->attachFriendToUser($user, $friend);
            $event->setName('attach.friend.post');
        } catch (\Exception $exception) {
            $event->setParam('exception', $exception);
            $event->setName('attach.friend.error');
            $this->getEventManager()->triggerEvent($event);
            throw $exception;
        }

        $this->getEventManager()->triggerEvent($event);
        return $return;
    }

    /**
     * Removes a friend from a user
     *
     * @param string|UserInterface $user
     * @param string|UserInterface $friend
     * @throws \Exception
     * @return bool
     */
    public function detachFriendFromUser($user, $friend)
    {
        $eventParams = ['user' => $user, 'friend' => $friend];
        $event       = new Event('detach.friend', $this->realService, $eventParams);
        $response    = $this->getEventManager()->triggerEvent($event);
        if ($response->stopped()) {
            return $response->last();
        }

        try {
            $return = $this->realService->detachFriendFromUser($user, $friend);
            $event->setName('detach.friend.post');
        } catch (\Exception $exception) {
            $event->setParam('exception', $exception);
            $event->setName('detach.friend.error');
            $this->getEventManager()->triggerEvent($event);
            throw $exception;
        }

        $this->getEventManager()->triggerEvent($event);
        return $return;
    }

    /**
     * Fetches a friend for a user
     *
     * SELECT
     *   u.*,
     *   uf.friend_id AS user_friend_id
     * FROM user_friends AS uf
     *   LEFT JOIN users AS u ON u.user_id = uf.user_id
     * WHERE uf.friend_id = :friend_id
     *   AND uf.user_id = :user_id;
     *
     * @param $user
     * @param $friend
     * @param null $prototype
     * @throws \Exception
     * @return object|UserInterface
     */
    public function fetchFriendForUser($user, $friend, $prototype = null)
    {
        $eventParams = ['user' => $user, 'friend' => $friend, 'prototype' => $prototype];
        $event       = new Event('fetch.friend', $this->realService, $eventParams);
        $response    = $this->getEventManager()->triggerEvent($event);
        if ($response->stopped()) {
            return $response->last();
        }

        try {
            $return = $this->realService->fetchFriendForUser($user, $friend, $prototype);
            $event->setName('fetch.friend.post');
        } catch (\Exception $exception) {
            $event->setParam('exception', $exception);
            $event->setName('fetch.friend.error');
            $this->getEventManager()->triggerEvent($event);
            throw $exception;
        }

        $this->getEventManager()->triggerEvent($event);
        return $return;
    }

    /**
     * Fetches the current friend status of a user
     *
     * @param UserInterface $user
     * @param UserInterface $friend
     * @throws \Exception
     * @return string
     */
    public function fetchFriendStatusForUser(UserInterface $user, UserInterface $friend)
    {
        $eventParams = ['user' => $user, 'friend' => $friend];
        $event       = new Event('fetch.friend.status', $this->realService, $eventParams);
        $response    = $this->getEventManager()->triggerEvent($event);
        if ($response->stopped()) {
            return $response->last();
        }

        try {
            $return = $this->realService->fetchFriendStatusForUser($user, $friend);
            $event->setName('fetch.friend.status.post');
            $event->setParam('status', $return);
        } catch (\Exception $exception) {
            $event->setParam('exception', $exception);
            $event->setName('fetch.friend.status.error');
            $this->getEventManager()->triggerEvent($event);
            throw $exception;
        }

        $this->getEventManager()->triggerEvent($event);
        return $return;
    }
}
