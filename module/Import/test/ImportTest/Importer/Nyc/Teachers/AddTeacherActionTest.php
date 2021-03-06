<?php

namespace ImportTest\Importer\Nyc\Teachers;

use Application\Exception\NotFoundException;
use Import\Importer\Nyc\Teachers\AddTeacherAction;
use Import\Importer\Nyc\Teachers\Teacher;
use Import\Importer\Nyc\Teachers\TeacherRegistry;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase as TestCase;
use User\Adult;

/**
 * Test AddTeacherActionTest
 *
 * @group Teacher
 * @group User
 * @group Action
 * @group Import
 * @group NycImport
 * @group UserService
 * @group Service
 */
class AddTeacherActionTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var TeacherRegistry
     */
    protected $registry;

    /**
     * @var \Mockery\MockInterface|\User\Service\UserServiceInterface
     */
    protected $service;

    /**
     * @before
     */
    public function setUpRegistry()
    {
        $this->registry = new TeacherRegistry($this->service);
    }

    /**
     * @before
     */
    public function setUpUserService()
    {
        $this->service = \Mockery::mock('\User\Service\UserServiceInterface');
        $this->service->shouldReceive('fetchUserByEmail')
            ->andThrow(new NotFoundException())
            ->byDefault();
    }

    /**
     * @return Teacher
     */
    protected function getGoodTeacher()
    {
        $teacher = new Teacher();
        $teacher->setFirstName('Chuck');
        $teacher->setLastName('Reeves');
        $teacher->setEmail('chuck@manchuck.com');
        $teacher->setRole('The man');

        return $teacher;
    }

    /**
     * @test
     */
    public function testItShouldReportCorrectAction()
    {
        $teacher = $this->getGoodTeacher();
        $action  = new AddTeacherAction($this->service, $teacher);

        $this->assertEquals(
            'Creating a user for the_man Chuck Reeves chuck@manchuck.com',
            $action->__toString(),
            'Add Teacher action reported incorrect command'
        );
    }

    /**
     * @test
     */
    public function testItShouldSaveTeacherToDataBase()
    {
        $teacher = $this->getGoodTeacher();

        $this->assertTrue(
            $teacher->isNew(),
            'Update this test for new teacher standards'
        );

        $action = new AddTeacherAction($this->service, $teacher);

        $this->assertEquals(50, $action->priority(), 'Priority for teacher has changed');
        $this->service->shouldReceive('createUser')
            ->once()
            ->andReturnUsing(function (Adult $user) {
                $this->assertEquals(
                    'Chuck',
                    $user->getFirstName(),
                    'Action did not map first name correctly'
                );

                $this->assertEquals(
                    'Reeves',
                    $user->getLastName(),
                    'Action did not map last name correctly'
                );

                $this->assertEquals(
                    'chuck@manchuck.com',
                    $user->getEmail(),
                    'Action did not map email correctly'
                );

                $this->assertEquals(
                    'chuck@manchuck.com',
                    $user->getUserName(),
                    'Action did not map username correctly'
                );

                return true;
            });

        $action->execute();
        $this->assertInstanceOf('\User\Adult', $teacher->getUser(), 'Action did not add user to teacher®');
    }
}
