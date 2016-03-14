<?php

namespace Import\Importer\Nyc\Parser;

use Group\GroupInterface;
use Group\Service\GroupServiceInterface;
use Import\ActionInterface;
use Import\Importer\Nyc\ClassRoom\ClassRoom;

/**
 * Class AddClassToSchooAction
 */
class AddClassToSchooAction implements ActionInterface
{
    /**
     * @var GroupServiceInterface
     */
    protected $groupService;

    /**
     * @var GroupInterface
     */
    protected $school;

    /**
     * @var ClassRoom
     */
    protected $classRoom;

    /**
     * AddClassToSchooAction constructor.
     * @param GroupInterface $school
     * @param ClassRoom $classRoom
     * @param GroupServiceInterface $groupService
     */
    public function __construct(GroupInterface $school, ClassRoom $classRoom, GroupServiceInterface $groupService)
    {
        $this->groupService = $groupService;
        $this->school       = $school;
        $this->classRoom    = $classRoom;
    }

    /**
     * Process the action
     *
     * @return void
     */
    public function execute()
    {
        $this->groupService->addChildToGroup($this->school, $this->classRoom->getGroup());
    }

    /**
     * The priority that the action should be processed in
     *
     * @return int
     */
    public function priority()
    {
        return 1;
    }


}
