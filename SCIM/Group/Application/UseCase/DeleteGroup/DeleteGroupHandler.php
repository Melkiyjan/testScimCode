<?php

namespace Tenant\Application\SCIM\Group\Application\UseCase\DeleteGroup;

use Symfony\Component\HttpFoundation\Response;
use Framework\Exception\JsonException;
use TC;
use Tenant\Application\Group\Domain\GroupRepositoryInterface;
use Tenant\Component\HandlerDiscovery\AbstractHandler;
use Tenant\Entity\Group;

/**
 * Class DeleteGroupHandler
 */
class DeleteGroupHandler extends AbstractHandler
{
    private GroupRepositoryInterface $groupRepository;

    /**
     * DeleteGroupHandler constructor.
     *
     * @param GroupRepositoryInterface $groupRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * @param DeleteGroupCommand $command
     *
     * @throws JsonException
     */
    public function handle(DeleteGroupCommand $command): void
    {
        $group = $this->groupRepository->getById($command->id);

        if ($group->getIsDefault()) {
            throw new JsonException(TC::EXCEPTION_GROUP_DELETE_SYSTEM);
        }

        $this->isNotLastGroupInDevice($group);

        $this->groupRepository->remove($group);
    }

    /**
     * @param Group $group
     *
     * @throws JsonException
     */
    private function isNotLastGroupInDevice(Group $group)
    {
        foreach ($group->getDevices() as $device) {
            if (1 === $device->getGroups()->count()) {
                throw new JsonException(TC::EXCEPTION_DEVICE_WITHOUT_SPACE, Response::HTTP_BAD_REQUEST, [], ['device' => $device->getName()]);
            }
        }
    }
}
