<?php

namespace UserTest\Service;

use IntegrationTest\TestHelper;
use PHPUnit\Framework\TestCase;
use User\Service\StaticNameService;
use User\UserName;

/**
 * Test StaticNameServiceTest
 *
 * @group User
 * @group Service
 * @group RandomName
 * @group RandomNameService
 */
class StaticNameServiceTest extends TestCase
{
    /**
     * @before
     */
    public function checkThatApplicationHasBeenBootstrapped()
    {
        $this->markTestSkipped('Fix the StaticNameService');
        $this->assertTrue(
            TestHelper::isBootstrapped(),
            'This test can only be run if the application has been bootstrapped'
        );
    }

    /**
     * @test
     */
    public function testItShouldThrowExceptionWhenListMissingKeys()
    {
        $leftThrown  = false;
        $rightThrown = false;

        try {
            StaticNameService::seedNames(['right' => []]);
        } catch (\InvalidArgumentException $leftException) {
            $this->assertEquals('Missing left or right values for names', $leftException->getMessage());
            $leftThrown = true;
        }
        try {
            StaticNameService::seedNames(['left' => []]);
        } catch (\InvalidArgumentException $rightException) {
            $this->assertEquals('Missing left or right values for names', $rightException->getMessage());
            $rightThrown = true;
        }

        $this->assertTrue($leftThrown && $rightThrown);
    }

    /**
     * @test
     */
    public function testItShouldThrowExceptionWhenKeysAreNotArrays()
    {
        $leftThrown  = false;
        $rightThrown = false;

        try {
            StaticNameService::seedNames(['left' => null, 'right' => []]);
        } catch (\InvalidArgumentException $leftException) {
            $this->assertEquals('left or right values must be an array', $leftException->getMessage());
            $leftThrown = true;
        }
        try {
            StaticNameService::seedNames(['left' => [], 'right' => null]);
        } catch (\InvalidArgumentException $rightException) {
            $this->assertEquals('left or right values must be an array', $rightException->getMessage());
            $rightThrown = true;
        }

        $this->assertTrue($leftThrown && $rightThrown);
    }

    /**
     * @test
     */
    public function testItShouldThrowExceptionWhenSelectingWrongPosition()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid position: foo');

        StaticNameService::getNames('foo');
    }

    /**
     * @test
     */
    public function testItShouldGenerateRandomNameAndNameShouldBeValidated()
    {
        $generatedName = StaticNameService::generateRandomName();
        $this->assertInstanceOf('\User\UserName', $generatedName, 'Invalid type returned');
        $this->assertTrue(StaticNameService::validateGeneratedName($generatedName), 'Generated Username is not valid');
    }

    /**
     * @test
     */
    public function testItShouldValidateFailureWhenGeneratedNameHasBadLeft()
    {
        $generatedName = StaticNameService::generateRandomName();
        $userName      = new UserName('foo', $generatedName->right);
        $this->assertFalse(StaticNameService::validateGeneratedName($userName));
    }

    /**
     * @test
     */
    public function testItShouldValidateFailureWhenGeneratedNameHasBadRight()
    {
        $generatedName = StaticNameService::generateRandomName();
        $userName      = new UserName($generatedName->left, 'foo');
        $this->assertFalse(StaticNameService::validateGeneratedName($userName));
    }
}
