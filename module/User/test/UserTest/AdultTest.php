<?php

namespace UserTest;

use PHPUnit\Framework\TestCase as TestCase;
use User\Adult;

/**
 * Test AdultTest
 *
 * @group User
 */
class AdultTest extends TestCase
{
    /**
     * @test
     */
    public function testItShouldExtractAndHydrateWithNulls()
    {
        $expected = [
            'user_id'     => '',
            'username'    => null,
            'email'       => null,
            'first_name'  => null,
            'middle_name' => null,
            'last_name'   => null,
            'gender'      => null,
            'birthdate'   => null,
            'created'     => null,
            'updated'     => null,
            'deleted'     => null,
            'type'        => Adult::TYPE_ADULT,
            'meta'        => [],
            'external_id' => null,
        ];

        $adult = new Adult();
        $adult->exchangeArray($expected);

        $this->assertEquals($expected, $adult->getArrayCopy());
    }

    /**
     * @test
     */
    public function testItShouldHydrateData()
    {
        $date = new \DateTime();

        $expected = [
            'user_id'     => 'abcd-efgh-ijklm-nop',
            'username'    => 'manchuck',
            'email'       => 'chuck@manchuck.com',
            'first_name'  => 'Charles',
            'middle_name' => 'Henry',
            'last_name'   => 'Reeves',
            'gender'      => Adult::GENDER_MALE,
            'birthdate'   => $date->format("Y-m-d H:i:s"),
            'created'     => $date->format("Y-m-d H:i:s"),
            'updated'     => $date->format("Y-m-d H:i:s"),
            'deleted'     => $date->format("Y-m-d H:i:s"),
            'type'        => Adult::TYPE_ADULT,
            'meta'        => [],
            'external_id' => 'foo-bar',
        ];

        $adult = new Adult();
        $adult->exchangeArray($expected);

        $this->assertEquals($expected, $adult->getArrayCopy());
    }

    /**
     * @test
     */
    public function testItShouldChangeUserNameForAdults()
    {
        $adult = new Adult();
        $adult->setUserName('manchuck');
        $adult->setUserName('foobar');

        $this->assertEquals('foobar', $adult->getUserName());
    }
}
