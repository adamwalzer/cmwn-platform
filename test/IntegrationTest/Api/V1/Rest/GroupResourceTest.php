<?php

namespace IntegrationTest\Api\V1\Rest;

use Application\Exception\NotFoundException;
use IntegrationTest\AbstractApigilityTestCase as TestCase;
use IntegrationTest\TestHelper;
use Group\Service\GroupServiceInterface;
use Zend\Json\Json;

/**
 * Test GroupResourceTest
 * @group DB
 * @group group
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */

class GroupResourceTest extends TestCase
{
    /**
     * @var GroupServiceInterface
     */
    protected $groupService;

    /**
     * @before
     */
    public function setUpUserService()
    {
        $this->groupService = TestHelper::getServiceManager()->get(GroupServiceInterface::class);
    }

    /**
     * @test
     */
    public function testToCheckIfUserIsLoggedInToAccessGroups()
    {
        $this->injectValidCsrfToken();

        $this->dispatch('/group');
        $this->assertResponseStatusCode(401);
    }

    /**
     * @test
     */
    public function testToCheckIfUserIsLoggedInToAccessAParticularGroup()
    {
        $this->injectValidCsrfToken();

        $this->dispatch('/group/school');
        $this->assertResponseStatusCode(401);
    }

    /**
     * @test
     * @ticket core-864
     */
    public function testItShouldReturnValidGroups()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $this->dispatch('/group');
        $this->assertMatchedRouteName('api.rest.group');
        $this->assertControllerName('api\v1\rest\group\controller');
        $this->assertResponseStatusCode(200);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('_embedded', $body);
        $this->assertArrayHasKey('group', $body['_embedded']);
        $groups = $body['_embedded']['group'];
        $expectedIds = ['english', 'school'];
        $actualIds = [];
        foreach ($groups as $group) {
            $this->assertArrayHasKey('group_id', $group);
            $actualIds[] = $group['group_id'];
        }
        $this->assertEquals($actualIds, $expectedIds);
    }

    /**
     * @test
     * @ticket core-864
     */
    public function testItShouldReturnSchoolForUser()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $this->dispatch('/group?type=school');
        $this->assertMatchedRouteName('api.rest.group');
        $this->assertControllerName('api\v1\rest\group\controller');
        $this->assertResponseStatusCode(200);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('_embedded', $body);
        $this->assertArrayHasKey('group', $body['_embedded']);
        $groups = $body['_embedded']['group'];
        $expectedIds = ['school'];
        $actualIds = [];
        foreach ($groups as $group) {
            $this->assertArrayHasKey('group_id', $group);
            $actualIds[] = $group['group_id'];
        }
        $this->assertEquals($actualIds, $expectedIds);
    }

    /**
     * @test
     */
    public function testItShouldReturnGroupData()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $this->dispatch('/group/school');
        $this->assertMatchedRouteName('api.rest.group');
        $this->assertControllerName('api\v1\rest\group\controller');
        $this->assertResponseStatusCode(200);
        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('group_id', $body);
        $this->assertArrayHasKey('organization_id', $body);
        $this->assertArrayHasKey('title', $body);
        $this->assertEquals('school', $body['group_id']);
        $this->assertEquals('district', $body['organization_id']);
        $this->assertEquals('Gina\'s School', $body['title']);
    }

    /**
     * @test
     */
    public function testItShould404WhenGroupWhichUserIsNotInIsAccessed()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $this->dispatch('/group/manchuck');
        $this->assertMatchedRouteName('api.rest.group');
        $this->assertControllerName('api\v1\rest\group\controller');
        $this->assertResponseStatusCode(404);
    }

    /**
     * @test
     */
    public function testItShould404WhenInvalidGroupIsAccessed()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $this->dispatch('/group/foobar');
        $this->assertMatchedRouteName('api.rest.group');
        $this->assertControllerName('api\v1\rest\group\controller');
        $this->assertResponseStatusCode(404);
    }

    /**
     * @test
     */
    public function testItShouldCreateGroup()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('super_user');

        $postData = array(
            'organization_id' => 'district',
            'title' => 'Joni School',
            'description' => 'this is new school',
            'meta' => null,
        );
        $this->dispatch('/group', POST, $postData);
        $this->assertMatchedRouteName('api.rest.group');
        $this->assertControllerName('api\v1\rest\group\controller');
        $this->assertResponseStatusCode(201);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('group_id', $body);
        $newGroup = $this->groupService->fetchGroup($body['group_id'])->getArrayCopy();
        $this->assertEquals('district', $newGroup['organization_id']);
        $this->assertEquals('Joni School', $newGroup['title']);
        $this->assertEquals('this is new school', $newGroup['description']);
        $this->assertEquals([], $newGroup['meta']);
    }

    /**
     * @test
     */
    public function testItShouldNotAllowOthersToCreateGroup()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $postData = array(
            'organization_id' => 'district',
            'title' => 'Joni School',
            'description' => 'this is new school',
            'meta' => null,
        );
        $this->dispatch('/group', POST, $postData);
        $this->assertResponseStatusCode(403);
    }

    /**
     * @test
     */
    public function testItShouldDeleteGroup()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('super_user');

        $this->dispatch('/group/school', DELETE);
        $this->assertResponseStatusCode(200);
        $this->setExpectedException(NotFoundException::class);
        $group = $this->groupService->fetchGroup('school')->getArrayCopy();
    }

    /**
     * @test
     */
    public function testItShouldNotAllowOthersToDeleteGroup()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_teacher');

        $this->dispatch('/group/school', DELETE);
        $this->assertResponseStatusCode(403);
    }

    /**
     * @test
     */
    public function testItShouldUpdateGroup()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('super_user');

        $putData = [
            'organization_id' => 'district',
            'title' => 'Joni School',
            'description' => 'this is new school',
            'meta' => null,
        ];
        $this->dispatch('/group/school', PUT, $putData);
        $this->assertResponseStatusCode(200);
        $group = $this->groupService->fetchGroup('school')->getArrayCopy();
        $this->assertEquals('district', $group['organization_id']);
        $this->assertEquals('Joni School', $group['title']);
        $this->assertEquals('this is new school', $group['description']);
        $this->assertEquals([], $group['meta']);
    }

    /**
     * @test
     */
    public function testItShouldNotAllowStudentToUpdateGroup()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');

        $putData = [
            'organization_id' => 'district',
            'title' => 'Joni School',
            'description' => 'this is new school',
            'meta' => null,
        ];
        $this->dispatch('/group/school', PUT, $putData);
        $this->assertResponseStatusCode(403);
    }
}
