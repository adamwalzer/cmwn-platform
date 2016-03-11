<?php

namespace GroupTest\Service;

use \PHPUnit_Framework_TestCase as TestCase;
use Group\Group;
use Group\Service\GroupService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Db\Sql\Predicate\Predicate as Where;

/**
 * Test GroupServiceTest
 *
 * @author Chuck "MANCHUCK" Reeves <chuck@manchuck.com>
 */
class GroupServiceTest extends TestCase
{
    /**
     * @var GroupService
     */
    protected $groupService;

    /**
     * @var \Mockery\MockInterface|\Zend\Db\TableGateway\TableGateway
     */
    protected $tableGateway;

    /**
     * @before
     */
    public function setUpGateWay()
    {
        /** @var \Mockery\MockInterface|\Zend\Db\Adapter\AdapterInterface $adapter */
        $adapter = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $adapter->shouldReceive('getPlatform')->byDefault();

        $this->tableGateway = \Mockery::mock('\Zend\Db\TableGateway\TableGateway');
        $this->tableGateway->shouldReceive('getTable')->andReturn('groups')->byDefault();
        $this->tableGateway->shouldReceive('getAdapter')->andReturn($adapter)->byDefault();
    }

    /**
     * @before
     */
    public function setUpService()
    {
        $this->groupService = new GroupService($this->tableGateway);
    }

    public function testItShouldReturnPaginatingAdapterByDefaultOnFetchAll()
    {
        $this->tableGateway
            ->shouldReceive('select')
            ->never();

        $result = $this->groupService->fetchAll(null);
        $this->assertInstanceOf('\Zend\Paginator\Adapter\AdapterInterface', $result);
    }

    public function testItShouldReturnIteratorOnFetchAllWithNoWhereAndNotPaginating()
    {
        $this->tableGateway
            ->shouldReceive('select')
            ->andReturnUsing(function ($where) {
                $this->assertInstanceOf('Zend\Db\Sql\Predicate\Predicate', $where);
                return new \ArrayIterator([]);
            })
            ->once();

        $result = $this->groupService->fetchAll(null, false);
        $this->assertInstanceOf('\Iterator', $result);
    }

    public function testItShouldReturnIteratorPassWhereWhenGivenWhereAndNotPaginating()
    {
        $expectedWhere = new Where();
        $this->tableGateway
            ->shouldReceive('select')
            ->andReturnUsing(function ($where) use (&$expectedWhere) {
                /** @var \Zend\Db\Sql\Predicate\Predicate $where */
                $this->assertSame($expectedWhere, $where);
                return new \ArrayIterator([]);

            })
            ->once();

        $result = $this->groupService->fetchAll($expectedWhere, false);
        $this->assertInstanceOf('\Iterator', $result);
    }

    public function testItShouldSaveNewGroup()
    {
        $newGroup = new Group();

        $this->assertNull($newGroup->getCreated());
        $this->assertNull($newGroup->getUpdated());
        $this->assertEmpty($newGroup->getGroupId());

        $this->tableGateway->shouldReceive('insert')
            ->andReturnUsing(function ($data) use (&$newGroup) {
                $this->assertNotNull($newGroup->getCreated());
                $this->assertNotNull($newGroup->getUpdated());
                $this->assertNotEmpty($newGroup->getGroupId());

                $this->assertTrue(is_array($data));

                $expected = $newGroup->getArrayCopy();
                $expected['meta'] = '[]';
                $expected['lft']  = $newGroup->getLeft();
                $expected['rgt']  = $newGroup->getRight();
                unset($expected['depth']);
                unset($expected['left']);
                unset($expected['right']);
                unset($expected['deleted']);
                $this->assertArrayNotHasKey('deleted', $data);
                $this->assertEquals($expected, $data);
                return 1;
            })
            ->once();

        $this->assertTrue($this->groupService->saveGroup($newGroup));
    }

    public function testItShouldUpdateExistingGroup()
    {
        $groupData = [
            'group_id'        => 'abcd-efgh-ijklm-nop',
            'organization_id' => 'abcd-efgh-ijklm-nop',
            'title'           => 'manchuck\s group',
            'description'     => 'My Awesome group',
            'type'            => 'school',
            'meta'            => [],
            'left'            => 1,
            'right'           => 2,
            'depth'           => 3,
            'created'         => '2016-02-28',
            'updated'         => '2016-02-28',
            'deleted'         => '2016-02-28',
        ];

        $group  = new Group($groupData);
        $result = new ResultSet();
        $result->initialize([$groupData]);
        $this->tableGateway->shouldReceive('select')
            ->with(['group_id' => $groupData['group_id']])
            ->andReturn($result);

        $this->tableGateway->shouldReceive('update')
            ->andReturnUsing(function ($data, $where) use (&$group) {
                $this->assertEquals(['group_id' => $group->getGroupId()], $where);
                $expected = $group->getArrayCopy();
                $expected['meta'] = '[]';
                $expected['lft']  = $group->getLeft();
                $expected['rgt']  = $group->getRight();
                unset($expected['deleted']);
                unset($expected['left']);
                unset($expected['right']);
                unset($expected['depth']);
                $this->assertArrayNotHasKey('deleted', $data);

                $this->assertEquals($expected, $data);

            });

        $this->assertTrue($this->groupService->saveGroup($group));
    }

    public function testItShouldFetchGroupById()
    {
        $groupData = [
            'group_id'        => 'abcd-efgh-ijklm-nop',
            'organization_id' => 'abcd-efgh-ijklm-nop',
            'title'           => 'manchuck\s group',
            'description'     => 'My Awesome group',
            'type'            => 'school',
            'meta'            => [],
            'left'            => 1,
            'right'           => 2,
            'depth'           => 3,
            'created'         => '2016-02-28',
            'updated'         => '2016-02-28',
            'deleted'         => '2016-02-28',
        ];

        $result = new ResultSet();
        $result->initialize([$groupData]);
        $this->tableGateway->shouldReceive('select')
            ->with(['group_id' => $groupData['group_id']])
            ->andReturn($result);

        $this->assertInstanceOf('Group\Group', $this->groupService->fetchGroup($groupData['group_id']));
    }

    public function testItShouldFetchGroupByExternalIdId()
    {
        $groupData = [
            'group_id'        => 'abcd-efgh-ijklm-nop',
            'organization_id' => 'abcd-efgh-ijklm-nop',
            'title'           => 'manchuck\s group',
            'description'     => 'My Awesome group',
            'type'            => 'school',
            'meta'            => [],
            'left'            => 1,
            'right'           => 2,
            'depth'           => 3,
            'created'         => '2016-02-28',
            'updated'         => '2016-02-28',
            'deleted'         => '2016-02-28',
            'external_id'     => 'foo-bar'
        ];

        $result = new ResultSet();
        $result->initialize([$groupData]);
        $this->tableGateway->shouldReceive('select')
            ->with(['external_id' => $groupData['external_id']])
            ->andReturn($result);

        $this->assertInstanceOf('Group\Group', $this->groupService->fetchGroupByExternalId($groupData['external_id']));
    }

    public function testItShouldThrowNotFoundExceptionWhenGroupIsNotFound()
    {
        $this->setExpectedException(
            'Application\Exception\NotFoundException',
            'Group not Found'
        );

        $result = new ResultSet();
        $result->initialize([]);
        $this->tableGateway->shouldReceive('select')
            ->andReturn($result);

        $this->groupService->fetchGroup('foo');
    }

    public function testItShouldThrowNotFoundExceptionWhenGroupIsNotFoundByExternalId()
    {
        $this->setExpectedException(
            'Application\Exception\NotFoundException',
            'Group not Found'
        );

        $result = new ResultSet();
        $result->initialize([]);
        $this->tableGateway->shouldReceive('select')
            ->andReturn($result);

        $this->groupService->fetchGroupByExternalId('foo');
    }

    public function testItShouldSoftDeleteByDefault()
    {
        $groupData = [
            'group_id'        => 'abcd-efgh-ijklm-nop',
            'organization_id' => 'abcd-efgh-ijklm-nop',
            'title'           => 'manchuck\s group',
            'description'     => 'My Awesome group',
            'type'            => 'school',
            'meta'            => [],
            'left'            => 1,
            'right'           => 2,
            'depth'           => 3,
            'created'         => '2016-02-28',
            'updated'         => '2016-02-28',
            'deleted'         => '',
        ];

        $group   = new Group($groupData);
        $result = new ResultSet();
        $result->initialize([$groupData]);
        $this->tableGateway->shouldReceive('select')
            ->with(['group_id' => $groupData['group_id']])
            ->andReturn($result);

        $this->tableGateway->shouldReceive('update')
            ->andReturnUsing(function ($data, $where) use (&$group) {
                $this->assertEquals(['group_id' => $group->getGroupId()], $where);
                $this->assertNotEmpty($data['deleted']);

            });

        $this->assertTrue($this->groupService->deleteGroup($group));
    }

    public function testItShouldSoftDeleteWhenForced()
    {
        $groupData = [
            'group_id'        => 'abcd-efgh-ijklm-nop',
            'organization_id' => 'abcd-efgh-ijklm-nop',
            'title'           => 'manchuck\s group',
            'description'     => 'My Awesome group',
            'type'            => 'school',
            'meta'            => [],
            'left'            => 1,
            'right'           => 2,
            'depth'           => 3,
            'created'         => '2016-02-28',
            'updated'         => '2016-02-28',
            'deleted'         => '',
        ];

        $group  = new Group($groupData);
        $result = new ResultSet();
        $result->initialize([$groupData]);
        $this->tableGateway->shouldReceive('select')
            ->with(['group_id' => $groupData['group_id']])
            ->andReturn($result);

        $this->tableGateway->shouldReceive('delete')
            ->andReturnUsing(function ($where) use (&$group) {
                $this->assertEquals(['group_id' => $group->getGroupId()], $where);

            });

        $this->assertTrue($this->groupService->deleteGroup($group, false));
    }

    public function testItShouldRebuildTreeWhenChildAddedForNewTree()
    {
        $parent = new Group([
            'group_id'        => 'parent',
            'left'            => 0,
            'right'           => 0,
        ]);

        $child = new Group();
        $child->setGroupId('child');

        $result = new ResultSet();
        $result->initialize([$parent->getArrayCopy()]);
        $this->tableGateway->shouldReceive('select')
            ->with(['group_id' => $parent->getGroupId()])
            ->andReturn($result);

        $this->tableGateway->shouldReceive('update')
            ->with(
                ['lft' => 1, 'rgt' => 4],
                ['group_id' => 'parent']
            )
            ->once();

        $this->tableGateway->shouldReceive('update')
            ->with(
                ['lft' => 2, 'rgt' => 3],
                ['group_id' => 'child']
            )
            ->once();

        $this->groupService->addChildToGroup($parent, $child);
    }

    public function testItShouldRebuildTreeWhenChildAddedForExistingTree()
    {
        $parent = new Group([
            'group_id'        => 'parent',
            'organization_id' => 'org',
            'left'            => 1,
            'right'           => 2,
        ]);

        $child = new Group();
        $child->setGroupId('child');

        $result = new ResultSet();
        $result->initialize([$parent->getArrayCopy()]);
        $this->tableGateway->shouldReceive('select')
            ->with(['group_id' => $parent->getGroupId()])
            ->andReturn($result);


        $this->tableGateway->shouldReceive('update')
            ->andReturnUsing(function ($actualSet, $actualWhere) {

                $expectedWhere = new Where();
                $expectedWhere->addPredicate(new Operator('rgt', 1, Operator::OP_GT));
                $expectedWhere->addPredicate(new Operator('org_id', 'org'));

                $this->assertInstanceOf('Zend\Db\Sql\Predicate\Predicate', $actualWhere);
                $this->assertEquals(['rgt' => 'rgt + 2'], $actualSet);
                $this->assertEquals($expectedWhere->getExpressionData(), $actualWhere->getExpressionData());
                return true;
            })
            ->times(1)
            ->ordered();

        $this->tableGateway->shouldReceive('update')
            ->andReturnUsing(function ($actualSet, $actualWhere) {

                $expectedWhere = new Where();
                $expectedWhere->addPredicate(new Operator('lft', 1, Operator::OP_GT));
                $expectedWhere->addPredicate(new Operator('org_id', 'org'));

                $this->assertInstanceOf('Zend\Db\Sql\Predicate\Predicate', $actualWhere);
                $this->assertEquals(['lft' => 'lft + 2'], $actualSet);
                $this->assertEquals($expectedWhere->getExpressionData(), $actualWhere->getExpressionData());
                return true;
            })
            ->times(1)
            ->ordered();

        $this->tableGateway->shouldReceive('update')
            ->andReturnUsing(function ($actualSet, $actualWhere) {
                $expectedWhere = new Where();
                $expectedWhere->addPredicate(new Operator('group_id', 'child'));

                $this->assertInstanceOf('Zend\Db\Sql\Predicate\Predicate', $actualWhere);
                $this->assertEquals(['lft' => 2, 'rgt' => 3], $actualSet);
                $this->assertEquals($expectedWhere->getExpressionData(), $actualWhere->getExpressionData());
                return true;
            })
            ->times(1)
            ->ordered();

        $this->groupService->addChildToGroup($parent, $child);
    }
}
