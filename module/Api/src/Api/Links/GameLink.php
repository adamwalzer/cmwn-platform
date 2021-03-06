<?php

namespace Api\Links;

use ZF\Hal\Link\Link;

/**
 * Class GameLink
 * TODO Make this as a templated link with same label
 * Hal link for a game
 */
class GameLink extends Link
{
    /**
     * GameLink constructor.
     * @param $entity
     * @param bool $deleted
     */
    public function __construct($entity, $deleted = false)
    {
        $label = 'games';
        $query = null;
        $propsLabel = 'Games';

        if ($deleted) {
            $label .= '_deleted';
            $query = ['deleted' => 'true'];
            $propsLabel = 'Deleted Games';
        }

        parent::__construct($label);
        $this->setProps(['label' => $propsLabel]);
        $this->setRoute('api.rest.game', [], ['query' => $query, 'reuse_matched_params' => false]);
    }
}
