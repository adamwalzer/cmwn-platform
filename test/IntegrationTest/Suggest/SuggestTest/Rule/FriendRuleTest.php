<?php

namespace SuggestTest\Rule;

use Friend\Service\FriendServiceInterface;
use IntegrationTest\TestHelper;
use IntegrationTest\AbstractDbTestCase as TestCase;
use Suggest\Rule\FriendRule;
use Suggest\SuggestionContainer;
use User\Child;
use User\UserInterface;

/**
 * Class FriendRuleTest
 * @package SuggestTest\Rule
 */
class FriendRuleTest extends TestCase
{
    /**
     * @var FriendRule
     */
    protected $friendRule;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var SuggestionContainer
     */
    protected $container;

    /**
     * @var FriendServiceInterface
     */
    protected $friendService;

    /**
     * @before
     */
    public function setUpUser()
    {
        $this->user = new Child(['user_id' => 'math_student']);
    }

    /**
     * @before
     */
    public function setUpFriendRule()
    {
        $this->friendRule = TestHelper::getServiceManager()->get(FriendRule::class);
    }

    /**
     * @before
     */
    public function setUpContainer()
    {
        $this->container = new SuggestionContainer();
        $suggestion = new Child(['user_id' => 'other_student']);
        $this->container[$suggestion->getUserId()] = $suggestion;
    }

    /**
     * @before
     */
    public function setUpFriendService()
    {
        $this->friendService = TestHelper::getServiceManager()->get(FriendServiceInterface::class);
    }

    /**
     * @test
     */
    public function testItShouldDoNothingIfNotFriends()
    {
        $this->friendRule->apply($this->container, $this->user);
        $expectedIds = ['other_student'];
        $actualIds = [];
        foreach ($this->container as $suggestion) {
            $actualIds[] = $suggestion->getUserId();
        }
        $this->assertEquals($expectedIds, $actualIds);
    }

    /**
     * @test
     */
    public function testItShouldRemoveSuggestionIfFriends()
    {
        $this->friendService->attachFriendToUser($this->user, new Child(['user_id' => 'other_student']));
        $this->friendService->attachFriendToUser(new Child(['user_id' => 'other_student']), $this->user);
        $this->friendRule->apply($this->container, $this->user);
        $expectedIds = [];
        $actualIds = [];
        foreach ($this->container as $suggestion) {
            $actualIds[] = $suggestion->getUserId();
        }
        $this->assertEquals($expectedIds, $actualIds);
    }
}