<?php

namespace Application\Exception;

/**
 * Class NotAuthorizedException
 * @package Application\Exception
 */
class NotAuthorizedException extends \Exception
{
    /**
     * NotAuthorizedException constructor.
     * @param null $message
     * @param null $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = null, \Exception $previous = null)
    {
        $code = 401;
        parent::__construct($message, $code, $previous);
    }
}
