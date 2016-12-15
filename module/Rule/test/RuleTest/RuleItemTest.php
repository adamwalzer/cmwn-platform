<?php

namespace RuleTest;

use \PHPUnit_Framework_TestCase as TestCase;
use Rule\RuleItem;

/**
 * Test RuleItemTest
 *
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RuleItemTest extends TestCase
{
    /**
     * @test
     */
    public function testItShouldCloneObjects()
    {
        $user = new \stdClass();
        $item = new RuleItem(['active_user' => $user]);

        $this->assertEquals(
            $user,
            $item->getParam('active_user'),
            'Rule Item did not return an equivalent active user'
        );

        $this->assertNotSame(
            $user,
            $item->getParam('active_user'),
            'Rule Item returned the same user.  ' .
            'This is bad we don\'t want to give rule specifications the ability to change the active user'
        );
    }

    /**
     * @test
     */
    public function testItShouldReturnArrays()
    {
        $data = ['foo' => 'bar'];
        $item = new RuleItem();
        $item->exchangeArray($data);

        $this->assertEquals(
            $data,
            $item->getArrayCopy(),
            'Rule Item did not return an equivalent data array'
        );

        $data['baz'] = 'bat';
        $this->assertEquals(
            ['foo' => 'bar'],
            $item->getArrayCopy(),
            'Rule Item returned the data array by reference.  ' .
            'This is bad we don\'t want to give rule specifications the ability to change the data in the item'
        );
    }
}
