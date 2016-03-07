<?php

namespace Group\Service;

use Group\GroupInterface;
use Org\OrganizationInterface;
use User\UserInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ArraySerializable;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Permissions\Acl\Role\RoleInterface;

/**
 * Service to manage attaching users to groups
 *
 * @package Group\Service
 */
class UserGroupService implements UserGroupServiceInterface
{
    /**
     * @var TableGateway
     */
    protected $pivotTable;

    /**
     * GroupService constructor.
     * @param TableGateway $pivotTable
     */
    public function __construct(TableGateway $pivotTable)
    {
        $this->pivotTable = $pivotTable;
    }

    /**
     * Attaches a user to a group
     *
     * @param GroupInterface $group
     * @param UserInterface $user
     * @param $role
     * @return bool
     * @throws \RuntimeException
     */
    public function attachUserToGroup(GroupInterface $group, UserInterface $user, $role)
    {
        if (!is_string($role) && !$role instanceof RoleInterface) {
            throw new \RuntimeException('Role must either be a sting or instance of Zend\PermissionAcl\RoleInterface');
        }

        $role = $role instanceof RoleInterface ? $role->getRoleId() : $role;

        $this->pivotTable->insert([
            'user_id'  => $user->getUserId(),
            'group_id' => $group->getGroupId(),
            'role'     => $role
        ]);

        return true;
    }

    /**
     * Detaches a user from a group
     *
     * @param GroupInterface $group
     * @param UserInterface $user
     * @return bool
     */
    public function detachUserFromGroup(GroupInterface $group, UserInterface $user)
    {
        $this->pivotTable->delete([
            'user_id'  => $user->getUserId(),
            'group_id' => $group->getGroupId()
        ]);

        return true;
    }

    /**
     * Finds all the users for a group
     *
     * SELECT *
     * FROM users u
     * LEFT JOIN user_groups ug ON ug.user_id = u.user_id
     * LEFT JOIN groups g ON ug.group_id = g.group_id
     * WHERE g.group_id = 'baz-bat'
     *
     * @param Where|GroupInterface|string $group
     * @param object $prototype
     * @return DbSelect
     */
    public function fetchUsersForGroup($group, $prototype = null)
    {
        $where = ($group instanceof Where) ? $group : new Where();

        if ($group instanceof GroupInterface) {
            $where->addPredicate(new Operator('g.group_id', Operator::OP_EQ, $group->getGroupId()));
        }

        if (is_string($group)) {
            $where->addPredicate(new Operator('g.group_id', Operator::OP_EQ, $group));
        }

        $select = new Select();
        $select->from(['u'  => 'users']);
        $select->join(['ug' => 'user_groups'], 'ug.user_id = u.user_id', [], Select::JOIN_LEFT);
        $select->join(['g'  => 'groups'], 'g.group_id = ug.group_id', [], Select::JOIN_LEFT);
        $select->where($where);

        $resultSet = new HydratingResultSet(new ArraySerializable(), $prototype);
        return new DbSelect(
            $select,
            $this->pivotTable->getAdapter(),
            $resultSet
        );
    }

    /**
     * Finds all the users for an organization
     *
     * SELECT *
     * FROM users u
     * LEFT JOIN user_groups ug ON ug.user_id = u.user_id
     * LEFT JOIN groups g ON ug.group_id = g.group_id
     * WHERE g.organization_id = 'foo-bar'
     *
     * @param $organization
     * @param null $prototype
     * @return DbSelect
     */
    public function fetchUsersForOrg($organization, $prototype = null)
    {
        $orgId = $organization instanceof OrganizationInterface ? $organization->getOrgId() : $organization;
        $where = new Where();
        $where->addPredicate(new Operator('g.organization_id', Operator::OP_EQ, $orgId));

        return $this->fetchUsersForGroup($where, $prototype);
    }
}
