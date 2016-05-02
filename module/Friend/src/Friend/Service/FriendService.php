<?php

namespace Friend\Service;

use Application\Utils\ServiceTrait;
use Friend\FriendInterface;
use Friend\NotFriendsException;
use User\UserHydrator;
use User\UserInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use \Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Db\Sql\Predicate\PredicateInterface;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ArraySerializable;
use Zend\Paginator\Adapter\DbSelect;

/**
 * Class FriendService
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FriendService implements FriendServiceInterface
{
    use ServiceTrait;

    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * FriendService constructor.
     *
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Fetches all the friends for a user
     *
     * @param string|UserInterface $user
     * @param null|array|PredicateInterface $where
     * @param null|UserInterface|object $prototype
     * @return DbSelect
     */
    public function fetchFriendsForUser($user, $where = null, $prototype = null)
    {
        $userId = $user instanceof UserInterface ? $user->getUserId() : $user;
        $where  = $this->createWhere($where);

        $select = new Select(['u' => 'users']);
        $select->join(
            ['uf' => 'user_friends'],
            new Expression('uf.user_id = ? OR uf.friend_id = ?', [$userId, $userId]),
            ['friend_id' => 'friend_id'],
            Select::JOIN_LEFT
        );

        $where->addPredicate(new Expression('u.user_id = uf.user_id'));
        $select->where($where);
        
        $hydrator  = $prototype instanceof UserInterface ? new ArraySerializable() : new UserHydrator();
        $resultSet = new HydratingResultSet($hydrator, $prototype);
        return new DbSelect(
            $select,
            $this->tableGateway->getAdapter(),
            $resultSet
        );
    }

    /**
     * Adds a friend to a user
     *
     * @param string|UserInterface $user
     * @param string|UserInterface $friend
     * @return bool
     */
    public function attachFriendToUser($user, $friend)
    {
        $userId   = $user instanceof UserInterface ? $user->getUserId() : $user;
        $friendId = $friend instanceof UserInterface ? $friend->getUserId() : $friend;

        try {
            /** @var \ArrayObject $currentStatus */
            $currentStatus = $this->fetchFriendForUser($user, $friend, new \ArrayObject());
        } catch (NotFriendsException $notFriends) {
            $this->tableGateway->insert([
                'user_id'   => $userId,
                'friend_id' => $friendId,
                'status'    => FriendInterface::PENDING
            ]);

            return true;
        }

        $isAccepting = $userId == $currentStatus['uf_friend_id'];

        if ($isAccepting && $currentStatus['uf_status'] === FriendInterface::PENDING) {
            $where = [
                'user_id'   => $currentStatus['uf_user_id'],
                'friend_id' => $currentStatus['uf_friend_id'],
                'status'    => $currentStatus['uf_status'],
            ];

            $this->tableGateway->update(
                ['status' => FriendInterface::FRIEND],
                $where
            );
        }

        return true;
    }

    /**
     * Removes a friend from a user
     *
     * @param string|UserInterface $user
     * @param string|UserInterface $friend
     * @return bool
     */
    public function detachFriendFromUser($user, $friend)
    {
        try {
            /** @var \ArrayObject $currentStatus */
            $currentStatus = $this->fetchFriendForUser($user, $friend, new \ArrayObject());
            $where = [
                'user_id'   => $currentStatus['uf_user_id'],
                'friend_id' => $currentStatus['uf_friend_id'],
                'status'    => $currentStatus['uf_status'],
            ];
            $this->tableGateway->delete($where);
        } catch (NotFriendsException $notFriends) {
            // no op the users are not friends
        }

        return true;
    }

    /**
     * Fetches a friend for a user
     *
     * SELECT *
     * FROM user_friends AS uf
     *    LEFT JOIN users AS u ON u.user_id = :friend_id
     * WHERE (uf.user_id = :user_id OR uf.friend_id = :user_id)
     *   AND (uf.user_id = :friend_id OR uf.friend_id = :friend_id)
     *
     * @param UserInterface|string $user
     * @param UserInterface|string $friend
     * @param null|object $prototype
     * @param null|string status
     * @throws NotFriendsException
     * @return object|UserInterface
     */
    public function fetchFriendForUser($user, $friend, $prototype = null, $status = null)
    {
        $select   = $this->createSelectForFriendsList($user, $friend);
        $hydrator = !$prototype instanceof UserInterface ? new ArraySerializable() : new UserHydrator();
        /** @var \Iterator|\Countable $results */
        $results  = $this->tableGateway->selectWith($select);

        if (count($results) < 1) {
            throw new NotFriendsException();
        }

        $results->rewind();
        $row = $results->current();
        return $hydrator->hydrate($row->getArrayCopy(), $prototype);
    }

    /**
     * Fetches the current friend status of a user
     *
     * @param UserInterface $user
     * @param UserInterface $friend
     * @return string
     */
    public function fetchFriendStatusForUser(UserInterface $user, UserInterface $friend)
    {
        try {
            $result = $this->fetchFriendForUser($user, $friend, new \ArrayObject());
        } catch (NotFriendsException $notFriends) {
            return FriendInterface::CAN_FRIEND;
        }

        return $result->offsetGet('uf_status');
    }

    /**
     * Creates the select statement for fetching friends
     *
     * @param UserInterface|string $user
     * @param UserInterface|string $friend
     * @return Select
     */
    protected function createSelectForFriendsList($user, $friend)
    {
        $userId   = $user instanceof UserInterface ? $user->getUserId() : $user;
        $friendId = $friend instanceof UserInterface ? $friend->getUserId() : $friend;

        $select = new Select(['uf' => 'user_friends']);
        $select->columns(['uf_user_id' => 'user_id', 'uf_friend_id' => 'friend_id', 'uf_status' => 'status']);
        $select->join(
            ['u' => 'users'],
            new Expression('u.user_id = ?', $friendId),
            ['*'],
            Select::JOIN_LEFT
        );

        $where = $this->createWhere([]);

        $firstOr = new PredicateSet();
        $firstOr->orPredicate(new Operator('uf.friend_id', '=', $userId));
        $firstOr->orPredicate(new Operator('uf.user_id', '=', $userId));

        $secondOr = new PredicateSet();
        $secondOr->orPredicate(new Operator('uf.friend_id', '=', $friendId));
        $secondOr->orPredicate(new Operator('uf.user_id', '=', $friendId));

        $where->addPredicate($firstOr);
        $where->addPredicate($secondOr);
        $select->where($where);

        return $select;
    }
}
