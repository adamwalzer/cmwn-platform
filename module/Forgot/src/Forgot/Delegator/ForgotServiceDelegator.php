<?php

namespace Forgot\Delegator;

use Forgot\Service\ForgotService;
use Forgot\Service\ForgotServiceInterface;
use User\UserInterface;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;

/**
 * Class ForgotServiceDelegator
 */
class ForgotServiceDelegator implements ForgotServiceInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * @var ForgotService
     */
    protected $realService;

    /**
     * @var string
     */
    protected $eventIdentifier = 'Forgot\Service\ForgotServiceInterface';

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * ForgotServiceDelegator constructor.
     * @param ForgotService $realService
     * @param EventManagerInterface $events
     */
    public function __construct(ForgotService $realService, EventManagerInterface $events)
    {
        $this->realService = $realService;
        $this->events      = $events;
        $events->addIdentifiers(array_merge(
            [ForgotServiceInterface::class, static::class, ForgotService::class],
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
     * Generates a code that the user can use to reset their password
     *
     * @param $email
     * @param null|string $code
     * @return bool|UserInterface
     */
    public function saveForgotPassword($email, $code = null)
    {
        $code = $code === null ? $this->generateCode() : $code;
        $event = new Event();
        $event->setParam('email', $email);
        $event->setParam('code', $code);
        $event->setTarget($this->realService);
        $event->setName('forgot.password');

        if ($this->getEventManager()->triggerEvent($event)->stopped()) {
            return true;
        }

        try {
            $user = $this->realService->saveForgotPassword($email, $code);
            $event->setParam('user', $user);
            $event->setName('forgot.password.post');
        } catch (\Exception $exception) {
            $event->setName('forgot.password.error');
            $event->setParam('exception', $exception);
        }

        $this->getEventManager()->triggerEvent($event);
        return true;
    }

    /**
     * @param int $length
     * @return string
     */
    public function generateCode($length = 10)
    {
        return $this->realService->generateCode($length);
    }
}
