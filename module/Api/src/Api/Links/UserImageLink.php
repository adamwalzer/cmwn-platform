<?php

namespace Api\Links;

use User\UserInterface;
use ZF\Hal\Link\Link;

/**
 * Class UserImageLink
 * @package Api\Links
 */
class UserImageLink extends Link
{
    /**
     * UserImageLink constructor.
     * @param string | UserInterface $userId
     */
    public function __construct($userId)
    {
        $userId = $userId instanceof UserInterface ? $userId->getUserId() : $userId;
        parent::__construct('user_image');
        $this->setProps(['label' => 'Profile Image']);
        $this->setRoute('api.rest.user-image', ['user_id' => $userId]);
    }
}
