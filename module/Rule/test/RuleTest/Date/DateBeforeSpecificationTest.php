<?php

namespace RuleTest\Date;

use \PHPUnit_Framework_TestCase as TestCase;
use Rule\Date\DateBeforeSpecification;
use Rule\Item\BasicRuleItem;

/**
 * Test DateAfterSpecificationTest
 *
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DateBeforeSpecificationTest extends TestCase
{
    /**
     * @test
     */
    public function testItShouldBeSatisfiedWhenCurrentDateIsAfterStartDate()
    {
        $endDate = new \DateTime('+1 hour');
        $rule    = new DateBeforeSpecification($endDate);

        $this->assertTrue(
            $rule->isSatisfiedBy(new BasicRuleItem()),
            'Date Before Rule was not satisfied when end date later than now'
        );
    }

    /**
     * @test
     */
    public function testItShouldNotBeSatisfiedWhenCurrentDateIsBeforeStartDate()
    {
        $endDate = new \DateTime('-1 hour');
        $rule    = new DateBeforeSpecification($endDate);

        $this->assertFalse(
            $rule->isSatisfiedBy(new BasicRuleItem()),
            'Date Before Rule was satisfied when end date earlier than now'
        );
    }
}
