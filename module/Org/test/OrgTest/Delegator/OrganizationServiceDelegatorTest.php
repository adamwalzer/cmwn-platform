<?php

namespace OrgTest\Delegator;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Org\Service\OrganizationService;
use PHPUnit\Framework\TestCase;
use Org\Organization;
use Org\Delegator\OrganizationServiceDelegator;
use Zend\Db\Sql\Where;
use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\Paginator\Adapter\ArrayAdapter;

/**
 * Test OrganizationServiceDelegatorTest
 *
 * @group Organization
 * @group Delegator
 * @group OrganizationService
 * @group Service
 */
class OrganizationServiceDelegatorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var \Mockery\MockInterface|\Org\Service\OrganizationService
     */
    protected $orgService;

    /**
     * @var OrganizationServiceDelegator
     */
    protected $delegator;

    /**
     * @var array
     */
    protected $calledEvents = [];

    /**
     * @var Organization
     */
    protected $org;

    /**
     * @before
     */
    public function setUpDelegator()
    {
        $this->calledEvents = [];
        $this->delegator    = new OrganizationServiceDelegator($this->orgService, new EventManager());
        $this->delegator->getEventManager()->clearListeners('fetch.all.orgs');
        $this->delegator->getEventManager()->attach('*', [$this, 'captureEvents'], 1000000);
    }

    /**
     * @before
     */
    public function setUpService()
    {
        $this->orgService = \Mockery::mock(OrganizationService::class);
    }

    /**
     * @before
     */
    public function setUpOrg()
    {
        $this->org = new Organization();
        $this->org->setOrgId(md5('foobar'));
    }

    /**
     * @param Event $event
     */
    public function captureEvents(Event $event)
    {
        $this->calledEvents[] = [
            'name'   => $event->getName(),
            'target' => $event->getTarget(),
            'params' => $event->getParams(),
        ];
    }

    /**
     * @test
     */
    public function testItShouldCallCreateOrganization()
    {
        $this->orgService->shouldReceive('createOrganization')
            ->once()
            ->with($this->org)
            ->andReturn(true);

        $this->delegator->createOrganization($this->org);

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'save.new.org',
                'target' => $this->orgService,
                'params' => ['org' => $this->org],
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'save.new.org.post',
                'target' => $this->orgService,
                'params' => ['org' => $this->org, 'result' => true],
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallUpdateOrganization()
    {
        $this->orgService->shouldReceive('updateOrganization')
            ->with($this->org)
            ->andReturn(true)
            ->once();

        $this->delegator->updateOrganization($this->org);

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'save.org',
                'target' => $this->orgService,
                'params' => ['org' => $this->org],
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'save.org.post',
                'target' => $this->orgService,
                'params' => ['org' => $this->org, 'result' => true],
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldNotCallCreateOrganizationWhenEventPrevents()
    {
        $this->orgService->shouldReceive('createOrganization')
            ->with($this->org)
            ->never();

        $this->delegator->getEventManager()->attach('save.new.org', function (Event $event) {
            $event->stopPropagation(true);

            return false;
        });

        $this->assertFalse($this->delegator->createOrganization($this->org));

        $this->assertEquals(1, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'save.new.org',
                'target' => $this->orgService,
                'params' => ['org' => $this->org],
            ],
            $this->calledEvents[0]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallFetchOrg()
    {
        $this->orgService->shouldReceive('fetchOrganization')
            ->with($this->org->getOrgId(), null)
            ->andReturn($this->org)
            ->once();

        $this->assertSame(
            $this->org,
            $this->delegator->fetchOrganization($this->org->getOrgId())
        );

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.org',
                'target' => $this->orgService,
                'params' => ['org_id' => $this->org->getOrgId()],
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'fetch.org.post',
                'target' => $this->orgService,
                'params' => ['org' => $this->org, 'org_id' => $this->org->getOrgId()],
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldNotCallFetchOrgAndReturnEventResult()
    {
        $this->orgService->shouldReceive('fetchOrg')
            ->with($this->org->getOrgId(), null)
            ->andReturn($this->org)
            ->never();

        $this->delegator->getEventManager()->attach('fetch.org', function (Event $event) {
            $event->stopPropagation(true);

            return $this->org;
        });

        $this->assertSame(
            $this->org,
            $this->delegator->fetchOrganization($this->org->getOrgId())
        );

        $this->assertEquals(1, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.org',
                'target' => $this->orgService,
                'params' => ['org_id' => $this->org->getOrgId()],
            ],
            $this->calledEvents[0]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallDeleteOrg()
    {
        $this->orgService->shouldReceive('deleteOrganization')
            ->with($this->org, true)
            ->andReturn(true)
            ->once();

        $this->assertTrue(
            $this->delegator->deleteOrganization($this->org)
        );

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'delete.org',
                'target' => $this->orgService,
                'params' => ['org' => $this->org, 'soft' => true],
            ],
            $this->calledEvents[0]
        );
        $this->assertEquals(
            [
                'name'   => 'delete.org.post',
                'target' => $this->orgService,
                'params' => ['org' => $this->org, 'soft' => true, 'result' => true],
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldNotCallDeleteOrgAndReturnEventResult()
    {
        $this->orgService->shouldReceive('deleteOrg')
            ->with($this->org, true)
            ->andReturn($this->org)
            ->never();

        $this->delegator->getEventManager()->attach('delete.org', function (Event $event) {
            $event->stopPropagation(true);

            return false;
        });

        $this->assertFalse(
            $this->delegator->deleteOrganization($this->org)
        );

        $this->assertEquals(1, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'delete.org',
                'target' => $this->orgService,
                'params' => ['org' => $this->org, 'soft' => true],
            ],
            $this->calledEvents[0]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallFetchAll()
    {
        $result = new ArrayAdapter([['foo' => 'bar']]);
        $this->orgService->shouldReceive('fetchAll')
            ->andReturn($result)
            ->once();

        $this->assertSame(
            $result,
            $this->delegator->fetchAll()
        );

        $this->assertEquals(2, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.all.orgs',
                'target' => $this->orgService,
                'params' => ['where' => new Where(), 'prototype' => null],
            ],
            $this->calledEvents[0]
        );

        $this->assertEquals(
            [
                'name'   => 'fetch.all.orgs.post',
                'target' => $this->orgService,
                'params' => ['where' => new Where(), 'prototype' => null, 'orgs' => $result],
            ],
            $this->calledEvents[1]
        );
    }

    /**
     * @test
     */
    public function testItShouldCallFetchAllWhenEventStops()
    {
        $result = new ArrayAdapter([['foo' => 'bar']]);
        $this->orgService->shouldReceive('fetchAll')
            ->andReturn($result)
            ->never();

        $this->delegator->getEventManager()->attach('fetch.all.orgs', function (Event $event) use (&$result) {
            $event->stopPropagation(true);

            return $result;
        });

        $this->assertSame(
            $result,
            $this->delegator->fetchAll()
        );

        $this->assertEquals(1, count($this->calledEvents));
        $this->assertEquals(
            [
                'name'   => 'fetch.all.orgs',
                'target' => $this->orgService,
                'params' => ['where' => new Where(), 'prototype' => null],
            ],
            $this->calledEvents[0]
        );
    }
}
