<?php

namespace IntegrationTest\Api\V1\Rest;

use IntegrationTest\AbstractApigilityTestCase as TestCase;
use Zend\Json\Json;
use IntegrationTest\TestHelper;
use Org\Service\OrganizationServiceInterface;
use Application\Exception\NotFoundException;

/**
 * Test OrgResourceTest
 * @group Org
 * @group DB
 * @group API
 * @group Integration
 * @group OrgService
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */

class OrgResourceTest extends TestCase
{
    /**
     * @var OrganizationServiceInterface
     */
    protected $orgService;

    /**
     * @before
     */
    public function setUpUserService()
    {
        $this->orgService = TestHelper::getServiceManager()->get(OrganizationServiceInterface::class);
    }

    /**
     * @test
     */
    public function testItShouldCheckIfUserLoggedIn()
    {
        $this->injectValidCsrfToken();

        $this->dispatch('/org/district');
        $this->assertResponseStatusCode(401);
    }

    /**
     * @test
     */
    public function testItShouldCheckCsrf()
    {
        $this->logInUser('english_student');

        $this->dispatch('/org/district');
        $this->assertResponseStatusCode(500);
    }

    /**
     * @test
     */
    public function testItShouldFetchOrg()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $this->dispatch('/org/district');
        $this->assertMatchedRouteName('api.rest.org');
        $this->assertControllerName('api\v1\rest\org\controller');
        $this->assertResponseStatusCode(200);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('org_id', $body);
        $this->assertArrayHasKey('title', $body);
        $this->assertArrayHasKey('description', $body);
        $this->assertArrayHasKey('type', $body);
        $this->assertEquals('district', $body['org_id']);
        $this->assertEquals('Gina\'s District', $body['title']);
        $this->assertEquals('district', $body['type']);
        $this->assertEquals(null, $body['description']);
    }

    /**
     * @test
     */
    public function testItShould404FetchOrg()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $this->dispatch('/org/foo');
        $this->assertMatchedRouteName('api.rest.org');
        $this->assertControllerName('api\v1\rest\org\controller');
        $this->assertResponseStatusCode(404);
    }

    /**
     * @test
     * @ticket CORE-884
     */
    public function testItShould403WhenUserFetchOtherOrg()
    {
        $this->markTestIncomplete("");
        $this->injectValidCsrfToken();
        $this->logInUser('math_student');

        $this->dispatch('/org/manchuck');
        $this->assertMatchedRouteName('api.rest.org');
        $this->assertControllerName('api\v1\rest\org\controller');
        $this->assertResponseStatusCode(200);
    }
    /**
     * @test
     */
    public function testItShouldFetchAllOrg()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('super_user');

        $this->dispatch('/org');
        $this->assertMatchedRouteName('api.rest.org');
        $this->assertControllerName('api\v1\rest\org\controller');
        $this->assertResponseStatusCode(200);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('_embedded', $body);
        $this->assertArrayHasKey('org', $body['_embedded']);
        $expectedIds = ['district', 'manchuck'];
        foreach ($body['_embedded']['org'] as $org) {
            $this->assertArrayHasKey('org_id', $org);
            $actualIds[] = $org['org_id'];
        }
        $this->assertEquals($expectedIds, $actualIds);
    }

    /**
     * @test
     */
    public function testItShouldFetchTheirOrgForOthers()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $this->dispatch('/org');
        $this->assertMatchedRouteName('api.rest.org');
        $this->assertControllerName('api\v1\rest\org\controller');
        $this->assertResponseStatusCode(200);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('_embedded', $body);
        $this->assertArrayHasKey('org', $body['_embedded']);
        $expectedIds = ['district'];
        foreach ($body['_embedded']['org'] as $org) {
            $this->assertArrayHasKey('org_id', $org);
            $actualIds[] = $org['org_id'];
        }
        $this->assertEquals($expectedIds, $actualIds);
    }

    /**
     * @test
     */
    public function testItShouldCreateOrganization()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('super_user');

        $this->dispatch(
            '/org',
            POST,
            [
                'title' => 'newOrg',
                'description' => 'new organization',
                'type' => 'district',
                'meta' => null,
            ]
        );
        $this->assertResponseStatusCode(201);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('org_id', $body);

        $newOrg = $this->orgService->fetchOrganization($body['org_id'])->getArrayCopy();
        $this->assertEquals('newOrg', $newOrg['title']);
        $this->assertEquals('new organization', $newOrg['description']);
        $this->assertEquals('district', $newOrg['type']);
        $this->assertEquals([], $newOrg['meta']);
    }

    /**
     * @test
     */
    public function testItShouldNotAllowOthersToCreateOrganization()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('math_teacher');

        $this->dispatch(
            '/org',
            POST,
            [
                'title' => 'newOrg',
                'description' => 'new organization',
                'type' => 'district',
                'meta' => null,
            ]
        );
        $this->assertResponseStatusCode(403);
    }

    /**
     * @test
     */
    public function testItShouldCheckCsrfToCreateOrganization()
    {
        $this->logInUser('super_user');

        $this->dispatch(
            '/org',
            POST,
            [
                'title' => 'newOrg',
                'description' => 'new organization',
                'type' => 'district',
                'meta' => null,
            ]
        );
        $this->assertResponseStatusCode(500);
    }

    /**
     * @test
     * @ticket CORE-885
     */
    public function testItShouldDeleteOrganization()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('super_user');

        $this->dispatch('/org/district', DELETE);
        $this->assertResponseStatusCode(200);
        $this->setExpectedException(NotFoundException::class);
        $this->orgService->fetchOrganization('district')->getArrayCopy();
    }

    /**
     * @test
     * @ticket CORE-886
     */
    public function testItShouldUpdateOrganization()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('super_user');

        $this->dispatch(
            '/org/district',
            PUT,
            [
                'title' => 'newOrg',
                'description' => 'new organization',
                'type' => 'district',
                'meta' => null,
            ]
        );
        $this->assertResponseStatusCode(200);

        $newOrg = $this->orgService->fetchOrganization('district')->getArrayCopy();
        $this->assertEquals('newOrg', $newOrg['title']);
        $this->assertEquals('new organization', $newOrg['description']);
        $this->assertEquals('district', $newOrg['type']);
        $this->assertEquals([], $newOrg['meta']);
    }
}
