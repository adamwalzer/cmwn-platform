<?php

namespace Game\Service;

use Application\Exception\NotFoundException;
use Game\Game;
use Game\GameInterface;
use User\UserInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ArraySerializable;
use Zend\Paginator\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;

/**
 *  Service that talks to the user_games table
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UserGameService implements UserGameServiceInterface
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * UserGameService constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @inheritdoc
     */
    public function fetchAllGamesForUser(
        UserInterface $user,
        $where = null,
        GameInterface $prototype = null
    ) : AdapterInterface {
        $where = $where ?? new Where();
        $select = $this->createSelect($user, $where);
        $select->quantifier(Select::QUANTIFIER_DISTINCT);
        $prototype = $prototype ?? new Game();
        $resultSet = new HydratingResultSet(new ArraySerializable(), $prototype);
        return new DbSelect($select, $this->tableGateway->getAdapter(), $resultSet);
    }

    /**
     * @inheritdoc
     */
    public function fetchGameForUser(
        UserInterface $user,
        GameInterface $game,
        GameInterface $prototype = null
    ) : GameInterface {
        $where = new Where([new Operator('g.game_id', Operator::OP_EQ, $game->getGameId())]);
        $select = $this->createSelect($user, $where);

        $rowSet = $this->tableGateway->selectWith($select);
        $row = $rowSet->current();
        if (!$row) {
            throw new NotFoundException('Game not found');
        }
        $prototype = $prototype ?? new Game();
        $prototype->exchangeArray($row->getArrayCopy());
        return $prototype;
    }

    /**
     * @inheritdoc
     */
    public function attachGameToUser(UserInterface $user, GameInterface $game) : bool
    {
        try {
            $this->tableGateway->insert(['user_id' => $user->getUserId(), 'game_id' => $game->getGameId()]);
        } catch (\PDOException $exception) {
            if ($exception->getCode()!== 23000) {
                throw $exception;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function detachGameForUser(UserInterface $user, GameInterface $game) : bool
    {
        $this->fetchGameForUser($user, $game);

        $this->tableGateway->delete(['user_id' => $user->getUserId(), 'game_id' => $game->getGameId()]);

        return true;
    }

    /**
     * @param UserInterface $user
     * @param Where $where
     * @return Select
     */
    protected function createSelect(UserInterface $user, Where $where) : Select
    {
        $select = new Select(['ug' => $this->tableGateway->getTable()]);
        $select->columns([]);
        $select->join(
            ['g' => 'games'],
            'ug.game_id = g.game_id',
            '*',
            Select::JOIN_RIGHT_OUTER
        );

        $where->addPredicate(
            new PredicateSet(
                [
                    new Expression('g.global =1'),
                    new Operator('ug.user_id', Operator::OP_EQ, $user->getUserId())
                ],
                PredicateSet::COMBINED_BY_OR
            )
        );

        $select->where($where);

        return $select;
    }
}
