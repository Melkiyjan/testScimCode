<?php

namespace Tenant\Application\SCIM\Group\Application\UseCase\UpdateGroup;

use Framework\Exception\JsonException;
use Tenant\Application\Group\Domain\GroupDomainService;
use Tenant\Application\Group\Domain\GroupRepositoryInterface;
use Tenant\Application\SCIM\Service\SCIMService;
use Tenant\Component\HandlerDiscovery\AbstractHandler;

/**
 * Class UpdateGroupHandler
 */
class UpdateGroupHandler extends AbstractHandler
{
    private GroupRepositoryInterface  $groupRepository;
    private SCIMService               $SCIMService;
    private GroupDomainService        $groupDomainService;

    /**
     * UpdateGroupHandler constructor.
     *
     * @param GroupRepositoryInterface $groupRepository
     * @param SCIMService              $SCIMService
     * @param GroupDomainService       $groupDomainService
     */
    public function __construct(
        GroupRepositoryInterface $groupRepository,
        SCIMService $SCIMService,
        GroupDomainService $groupDomainService
    ) {
        $this->groupRepository = $groupRepository;
        $this->SCIMService = $SCIMService;
        $this->groupDomainService = $groupDomainService;
    }

    /**
     * @param UpdateGroupCommand $updateGroupCommand
     *
     * @throws JsonException
     */
    public function handle(UpdateGroupCommand $updateGroupCommand): void
    {
        $group = $this->groupRepository->getById($updateGroupCommand->id);
        $users = $this->SCIMService->findUsersBySCIMMembers($updateGroupCommand->members);

        $data = [
            GroupDomainService::PROP_NAME => $updateGroupCommand->displayName,
            GroupDomainService::PROP_USERS => $users,
        ];

        $this->groupDomainService->update($group, $data);

        $this->groupRepository->save($group);
    }
}
