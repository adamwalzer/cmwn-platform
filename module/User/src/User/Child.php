<?php

namespace User;

use User\Service\StaticNameService;

class Child extends User implements ChildInterface
{
    /**
     * @var \stdClass|null
     */
    protected $generatedName;

    /**
     * @return string
     */
    public function getType()
    {
        return static::TYPE_CHILD;
    }

    /**
     * Generates a random user name for the child
     *
     * @return string
     */
    public function getUserName()
    {
        if (parent::getUserName() === null) {
            $generatedName = StaticNameService::generateRandomName();
            $this->setUserName($generatedName->userName);
            $this->generatedName = $generatedName;
        }

        return parent::getUserName();
    }

    /**
     * @param string $userName
     * @return $this
     */
    public function setUserName($userName)
    {
        if ($this->userName === null) {
            parent::setUserName($userName);
            $this->generatedName = null;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isNameGenerated()
    {
        return $this->generatedName !== null;
    }

    /**
     * @return null|\stdClass
     */
    public function getGenratedName()
    {
        return $this->generatedName;
    }
}
