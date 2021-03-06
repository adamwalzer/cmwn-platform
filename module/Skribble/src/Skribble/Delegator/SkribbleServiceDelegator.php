<?php

namespace Skribble\Delegator;

use Application\Utils\HideDeletedEntitiesListener;
use Application\Utils\ServiceTrait;
use Skribble\Service\SkribbleService;
use Skribble\Service\SkribbleServiceInterface;
use Skribble\SkribbleInterface;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;

/**
 * Class SkribbleServiceDelegator
 */
class SkribbleServiceDelegator implements SkribbleServiceInterface
{
    use ServiceTrait;

    /**
     * @var array
     */
    protected $eventIdentifier = [SkribbleServiceInterface::class];

    /**
     * @var SkribbleService
     */
    protected $realService;

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * SkribbleServiceDelegator constructor.
     * @param SkribbleService $service
     * @param EventManagerInterface $events
     */
    public function __construct(SkribbleService $service, EventManagerInterface $events)
    {
        $this->realService = $service;
        $this->events      = $events;
        $events->addIdentifiers(array_merge(
            [SkribbleServiceInterface::class, static::class, SkribbleService::class],
            $events->getIdentifiers()
        ));
        $this->attachDefaultListeners();
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->events;
    }

    /**
     *
     */
    protected function attachDefaultListeners()
    {
        $hideListener = new HideDeletedEntitiesListener(
            ['fetch.all.skribbles'],
            ['fetch.skribble.post']
        );

        $hideListener->setEntityParamKey('skribble');
        $hideListener->setDeletedField('s.deleted');
        $hideListener->attach($this->getEventManager());
    }

    /**
     * @inheritDoc
     */
    public function fetchAllForUser($user, $where = null, $prototype = null)
    {
        $where = $this->createWhere($where);
        $event = new Event(
            'fetch.all.skribbles',
            $this->realService,
            ['user' => $user, 'where' => $where, 'prototype' => $prototype]
        );

        $response = $this->getEventManager()->triggerEvent($event);

        if ($response->stopped()) {
            return $response->last();
        }

        $return = $this->realService->fetchAllForUser($user, $where, $prototype);

        $event->setName('fetch.all.skribbles.post');
        $event->setParam('result', $return);

        $this->getEventManager()->triggerEvent($event);

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function fetchReceivedForUser($user, $where = null, $prototype = null)
    {
        $where = $this->createWhere($where);
        $event = new Event(
            'fetch.all.received.skribbles',
            $this->realService,
            ['user' => $user, 'where' => $where, 'prototype' => $prototype]
        );

        $response = $this->getEventManager()->triggerEvent($event);

        if ($response->stopped()) {
            return $response->last();
        }

        $return = $this->realService->fetchReceivedForUser($user, $where, $prototype);

        $event->setName('fetch.all.received.skribbles.post');
        $event->setParam('result', $return);

        $this->getEventManager()->triggerEvent($event);

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function fetchSentForUser($user, $where = null, $prototype = null)
    {
        $where = $this->createWhere($where);
        $event = new Event(
            'fetch.all.sent.skribbles',
            $this->realService,
            ['user' => $user, 'where' => $where, 'prototype' => $prototype]
        );

        $response = $this->getEventManager()->triggerEvent($event);

        if ($response->stopped()) {
            return $response->last();
        }

        $return = $this->realService->fetchSentForUser($user, $where, $prototype);

        $event->setName('fetch.all.sent.skribbles.post');
        $event->setParam('result', $return);

        $this->getEventManager()->triggerEvent($event);

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function fetchDraftForUser($user, $where = null, $prototype = null)
    {
        $where = $this->createWhere($where);
        $event = new Event(
            'fetch.all.draft.skribbles',
            $this->realService,
            ['user' => $user, 'where' => $where, 'prototype' => $prototype]
        );

        $response = $this->getEventManager()->triggerEvent($event);

        if ($response->stopped()) {
            return $response->last();
        }

        $return = $this->realService->fetchDraftForUser($user, $where, $prototype);

        $event->setName('fetch.all.draft.skribbles.post');
        $event->setParam('result', $return);

        $this->getEventManager()->triggerEvent($event);

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function fetchSkribble($skribbleId, $prototype = null)
    {
        $event = new Event(
            'fetch.skribble',
            $this->realService,
            ['skirbble_id' => $skribbleId, 'prototype' => $prototype]
        );

        $response = $this->getEventManager()->triggerEvent($event);

        if ($response->stopped()) {
            return $response->last();
        }

        $return = $this->realService->fetchSkribble($skribbleId, $prototype);

        $event->setName('fetch.skribble.post');
        $event->setParam('skribble', $return);

        $this->getEventManager()->triggerEvent($event);

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function createSkribble(SkribbleInterface $skribble)
    {
        $event = new Event(
            'create.skribble',
            $this->realService,
            ['skribble' => $skribble]
        );

        $response = $this->getEventManager()->triggerEvent($event);

        if ($response->stopped()) {
            return $response->last();
        }

        try {
            $return = $this->realService->createSkribble($skribble);
            $event->setName('create.skribble.post');
        } catch (\Exception $createException) {
            $event->setName('create.skribble.error');
            $event->setParam('error', $createException);
            $this->getEventManager()->triggerEvent($event);
            throw $createException;
        }

        $this->getEventManager()->triggerEvent($event);

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function updateSkribble(SkribbleInterface $skribble)
    {
        $event = new Event(
            'update.skribble',
            $this->realService,
            ['skribble' => $skribble]
        );

        $response = $this->getEventManager()->triggerEvent($event);

        if ($response->stopped()) {
            return $response->last();
        }

        try {
            $return = $this->realService->updateSkribble($skribble);
            $event->setName('update.skribble.post');
        } catch (\Exception $updateException) {
            $event->setName('update.skribble.error');
            $event->setParam('error', $updateException);
            $this->getEventManager()->triggerEvent($event);
            throw $updateException;
        }

        $this->getEventManager()->triggerEvent($event);

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function deleteSkribble($skribble, $hard = false)
    {
        $event = new Event(
            'delete.skribble',
            $this->realService,
            ['skribble' => $skribble, 'hard' => $hard]
        );

        $response = $this->getEventManager()->triggerEvent($event);

        if ($response->stopped()) {
            return $response->last();
        }

        try {
            $return = $this->realService->deleteSkribble($skribble, $hard);

            $event->setName('delete.skribble.post');
        } catch (\Exception $deleteException) {
            $event->setName('delete.skribble.error');
            $event->setParam('error', $deleteException);
            $this->getEventManager()->triggerEvent($event);
            throw $deleteException;
        }
        $this->getEventManager()->triggerEvent($event);

        return $return;
    }
}
