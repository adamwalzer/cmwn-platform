<?php

namespace IntegrationTest\Api\V1\Rest;

use Address\Service\AddressServiceInterface;
use Application\Exception\NotFoundException;
use IntegrationTest\AbstractApigilityTestCase;
use IntegrationTest\TestHelper;
use Zend\Json\Json;

/**
 * Class AddressResourceTest
 * @package IntegrationTest\Api\V1\Rest
 * @SuppressWarnings(PHPMD)
 */
class AddressResourceTest extends AbstractApigilityTestCase
{
    /**
     * @var AddressServiceInterface $addressService
     */
    protected $addressService;

    /**
     * @inheritdoc
     */
    public function getDataSet()
    {
        return $this->createArrayDataSet(include __DIR__ . '/../../../DataSets/AddressDataSet.php');
    }

    /**
     * @before
     */
    public function setUpAddressService()
    {
        $this->addressService = TestHelper::getServiceManager()->get(AddressServiceInterface::class);
    }

    /**
     * @test
     */
    public function testItShouldCheckCsrf()
    {
        $this->logInUser('super_user');
        $this->dispatch('/address');
        $this->assertResponseStatusCode(500);
    }

    /**
     * @test
     */
    public function testItShouldCheckIfUserIsLoggedIn()
    {
        $this->injectValidCsrfToken();
        $this->dispatch('/address');
        $this->assertResponseStatusCode(401);
    }

    /**
     * @test
     * @dataProvider userDataProvider
     */
    public function testItShouldCheckChangePasswordException($login)
    {
        $this->injectValidCsrfToken();
        $this->logInChangePasswordUser($login);
        $this->dispatch('/address');
        $this->assertResponseStatusCode(401);
    }

    /**
     * @test
     * @dataProvider userDataProvider
     */
    public function testItShouldFetchAllAddresses($login)
    {
        $this->injectValidCsrfToken();
        $this->logInUser($login);
        $this->dispatch('/address');
        $this->assertResponseStatusCode(200);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('_embedded', $body);
        $this->assertArrayHasKey('address', $body['_embedded']);
        $addresses = $body['_embedded']['address'];
        $expected = ['foo_school_address', 'other_school_address', 'school_address'];
        $actual = [];

        foreach ($addresses as $address) {
            $this->assertArrayHasKey('address_id', $address);
            $actual[] = $address['address_id'];
        }
        $this->assertEquals($actual, $expected);
    }

    /**
     * @test
     */
    public function testItShouldFetchAllAddressesWithGroupsAttached()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('super_user');
        $this->dispatch('/address?postal_code=07306&filter=group');
        $this->assertResponseStatusCode(200);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('_embedded', $body);
        $this->assertArrayHasKey('address', $body['_embedded']);
        $addresses = $body['_embedded']['address'];
        $expected = ['foo_school_address', 'other_school_address'];
        $actual = [];

        foreach ($addresses as $address) {
            $this->assertArrayHasKey('address_id', $address);
            $actual[] = $address['address_id'];
        }
        $this->assertEquals($actual, $expected);
    }

    /**
     * @test
     * @dataProvider userDataProvider
     */
    public function testItShouldFetchAddressById($login)
    {
        $this->injectValidCsrfToken();
        $this->logInUser($login);
        $this->dispatch('/address/school_address');
        $this->assertResponseStatusCode(200);
    }

    /**
     * @test
     * @dataProvider cudDataProvider
     */
    public function testItShouldCreateAddress($login)
    {
        $this->injectValidCsrfToken();
        $this->logInUser($login);
        $postData = [
            'country'                 => 'US',
            'administrative_area'     => 'US-NY',
            'sub_administrative_area' => null,
            'locality'                => 'ny',
            'dependent_locality'      => null,
            'postal_code'             => '10036',
            'thoroughfare'            => '21 W 46th St',
            'premise'                 => null,
        ];
        $this->dispatch('/address', 'POST', $postData);
        $this->assertResponseStatusCode(201);

        $body = Json::decode($this->getResponse()->getContent(), Json::TYPE_ARRAY);
        $this->assertArrayHasKey('address_id', $body);
        $addressId = $body['address_id'];
        try {
            $address = $this->addressService->fetchAddress($addressId);
            $postData['address_id'] = $addressId;
            $this->assertEquals($postData, $address->getArrayCopy());
        } catch (NotFoundException $nf) {
            $this->fail('it did not create address correctly');
        }
    }

    /**
     * @test
     * @dataProvider cudDataProvider
     */
    public function testItShould422ForIncorrectInputFilter($login)
    {
        $this->injectValidCsrfToken();
        $this->logInUser($login);
        $postData = [
            'country'                 => null,
            'administrative_area'     => null,
            'sub_administrative_area' => null,
            'locality'                => null,
            'dependent_locality'      => null,
            'postal_code'             => '10036',
            'thoroughfare'            => '21 W 46th St',
            'premise'                 => null,
        ];
        $this->dispatch('/address', 'POST', $postData);
        $this->assertResponseStatusCode(422);
    }

    /**
     * @test
     */
    public function testItShould403ForUnauthorizedCreate()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');
        $postData = [
            'country'                 => 'US',
            'administrative_area'     => 'US-NY',
            'sub_administrative_area' => null,
            'locality'                => 'ny',
            'dependent_locality'      => null,
            'postal_code'             => '10036',
            'thoroughfare'            => '21 W 46th St',
            'premise'                 => null,
        ];
        $this->dispatch('/address', 'POST', $postData);
        $this->assertResponseStatusCode(403);
    }

    /**
     * @test
     */
    public function testItShould403ForUnauthorizedUpdate()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');
        $postData = [
            'country'                 => 'US',
            'administrative_area'     => 'US-NY',
            'sub_administrative_area' => null,
            'locality'                => 'ny',
            'dependent_locality'      => null,
            'postal_code'             => '10036',
            'thoroughfare'            => '21 W 46th St',
            'premise'                 => null,
        ];
        $this->dispatch('/address', 'PUT', $postData);
        $this->assertResponseStatusCode(403);
    }

    /**
     * @test
     */
    public function testItShould403ForUnauthorizedDelete()
    {
        $this->injectValidCsrfToken();
        $this->logInUser('english_student');
        $this->dispatch('/address', 'DELETE');
        $this->assertResponseStatusCode(403);
    }

    /**
     * @test
     * @dataProvider cudDataProvider
     */
    public function testItShouldUpdateAddress($login)
    {
        $this->injectValidCsrfToken();
        $this->logInUser($login);
        $postData = [
            'address_id'              => 'school_address',
            'country'                 => 'US',
            'administrative_area'     => 'US-NY',
            'sub_administrative_area' => null,
            'locality'                => 'ny',
            'dependent_locality'      => null,
            'postal_code'             => '10036',
            'thoroughfare'            => '21 W 46th St',
            'premise'                 => null,
        ];
        $this->dispatch('/address/school_address', 'PUT', $postData);
        $this->assertResponseStatusCode(200);

        $address = $this->addressService->fetchAddress('school_address');
        $this->assertEquals('US-NY', $address->getAdministrativeArea());
    }

    /**
     * @test
     * @dataProvider cudDataProvider
     */
    public function testItShouldDeleteAddress($login)
    {
        $this->injectValidCsrfToken();
        $this->logInUser($login);
        $this->dispatch('/address/school_address', 'DELETE');
        $this->assertResponseStatusCode(204);

        try {
            $this->addressService->fetchAddress('school_address');
            $this->fail("it did not delete correctly");
        } catch (NotFoundException $nf) {
            //noop
        }
    }

    /**
     * return array
     */
    public function cudDataProvider()
    {
        return [
            [
                'super_user'
            ],
            [
                'principal'
            ],
            [
                'english_teacher'
            ],
        ];
    }

    /**
     * return array
     */
    public function userDataProvider()
    {
        return [
            [
                'super_user'
            ],
            [
                'principal'
            ],
            [
                'english_teacher'
            ],
            [
                'english_student'
            ],
        ];
    }
}
