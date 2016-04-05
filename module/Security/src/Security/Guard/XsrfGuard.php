<?php

namespace Security\Guard;

use Application\Utils\NoopLoggerAwareTrait;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Http\Header\Cookie;
use Zend\Http\Header\SetCookie;
use Zend\Http\PhpEnvironment\Request as HttpRequest;
use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\Log\LoggerAwareInterface;
use Zend\Mvc\MvcEvent;
use Zend\Validator\Csrf;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

/**
 * Class CsrfGuard
 *
 * Checks XSRF token on requests
 *
 * @package Security\Guard
 */
class XsrfGuard extends Csrf implements LoggerAwareInterface
{
    use NoopLoggerAwareTrait;

    protected $listeners = [];

    /**
     * @param SharedEventManagerInterface $events
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('*', MvcEvent::EVENT_FINISH, [$this, 'onFinish'], 210);
        $this->listeners[] = $events->attach('*', MvcEvent::EVENT_ROUTE, [$this, 'onRoute'], 210);
    }

    /**
     * @param SharedEventManagerInterface $events
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $listener) {
            $events->detach('*', $listener);
        }
    }

    /**
     * Forces the session name
     *
     * @return string
     */
    public function getSessionName()
    {
        return 'CMWN_XSRF';
    }

    /**
     * Generates a new hash if one is not set
     *
     * @return mixed
     */
    protected function getHashFromSession()
    {
        $session = $this->getSession();
        if (!$session->hash) {
            $this->generateHash();
        }

        return $session->hash;
    }

    /**
     * @param MvcEvent $event
     * @return null|void|ApiProblemResponse
     */
    public function onFinish(MvcEvent $event)
    {
        $response = $event->getResponse();

        /** @var HttpRequest $request */
        $request  = $event->getRequest();

        // Coming in from the console
        if (!$response instanceof HttpResponse) {
            return null;
        }

        $cookie = $request->getCookie();
        if ($cookie && $cookie->offsetExists('XSRF-TOKEN')) {
            return null;
        }

        $cookie = new SetCookie(
            'XSRF-TOKEN',
            $this->getHashFromSession(),
            time() + 600,
            '/',
            $event->getRequest()->getServer('HTTP_HOST'),
            true,
            true
        );

        $response->getHeaders()->addHeader($cookie);
        return null;
    }

    /**
     * @param MvcEvent $event
     * @return null|void|ApiProblemResponse
     */
    public function onRoute(MvcEvent $event)
    {
        $response = $event->getResponse();

        /** @var HttpRequest $request */
        $request  = $event->getRequest();

        // Coming in from the console
        if (!$response instanceof HttpResponse) {
            return null;
        }

        $cookie = $request->getCookie();
        if ($cookie && $cookie->offsetExists('XSRF-TOKEN')) {
            return $this->verifyToken($cookie);
        }
    }

    /**
     * @param Cookie $cookie
     * @return null|ApiProblemResponse
     */
    protected function verifyToken(Cookie $cookie)
    {
        if ($cookie->offsetGet('XSRF-TOKEN') !== $this->getHashFromSession()) {
            $this->getLogger()->alert(
                'Attempt to access the site with an invalid XSRF token',
                ['actual_token' => $cookie->offsetGet('XSRF-TOKEN'), 'expected_token' => $this->getHashFromSession()]
            );

            return new ApiProblemResponse(new ApiProblem(500, 'Invalid Token'));
        }

        return null;
    }
}
