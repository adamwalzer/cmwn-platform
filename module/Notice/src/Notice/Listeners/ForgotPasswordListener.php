<?php

namespace Notice\Listeners;

use AcMailer\Service\MailServiceAwareTrait;
use Forgot\Service\ForgotServiceInterface;
use Notice\EmailModel\ForgotEmailModel;
use Notice\NoticeInterface;
use User\Child;
use User\UserInterface;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\View\Exception;

/**
 * Class ForgotPasswordListener
 */
class ForgotPasswordListener implements NoticeInterface
{
    use MailServiceAwareTrait;

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

    /**
     * @var ForgotEmailModel
     */
    protected $emailModel;

    /**
     * ForgotPasswordListener constructor.
     * @param ForgotEmailModel $emailModel
     */
    public function __construct($emailModel)
    {
        $this->emailModel = $emailModel;
    }

    /**
     * @param SharedEventManagerInterface $manager
     * @codeCoverageIgnore
     */
    public function attachShared(SharedEventManagerInterface $manager)
    {
        $this->listeners[] = $manager->attach(
            ForgotServiceInterface::class,
            'forgot.password.post',
            [$this, 'notify']
        );
    }

    /**
     * @param SharedEventManagerInterface $manager
     * @codeCoverageIgnore
     */
    public function detachShared(SharedEventManagerInterface $manager)
    {
        foreach ($this->listeners as $listener) {
            $manager->detach(ForgotServiceInterface::class, $listener);
        }
    }

    /**
     * Send out a notice about the import
     *
     * @param Event $event
     * @return null
     */
    public function notify(Event $event)
    {
        $user = $event->getParam('user');

        if (!$user instanceof UserInterface) {
            return null;
        }

        if ($user instanceof Child) {
            return null;
        }

        $this->getMailService()->getMessage()->setTo($user->getEmail());
        $this->getMailService()->getMessage()->setSubject('Reset Password Code');
        $this->emailModel->setVariable('user', $user->getArrayCopy());
        $this->emailModel->setVariable('code', $event->getParam('code'));
        try {
            $this->getMailService()->setTemplate(
                $this->emailModel
            );
        } catch (Exception\RuntimeException $e) {
            return;
        }

        $this->getMailService()->send();
        return null;
    }
}
