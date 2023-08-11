<?php

namespace Tenant\Application\SCIM\Group\Application\UseCase\GetGroup;

use Tenant\Application\Group\Domain\GroupRepositoryInterface;
use Tenant\Component\HandlerDiscovery\AbstractHandler;

/**
 * Class GetGroupHandler
 */
class GetGroupHandler extends AbstractHandler
{
    private GroupRepositoryInterface $groupRepository;

    /**
     * GetGroupHandler constructor.
     *
     * @param GroupRepositoryInterface $groupRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * @param GetGroupQuery $getGroupQuery
     *
     * @return GetGroupResponse
     *
     * @throws
     */
    public function handle(GetGroupQuery $getGroupQuery): GetGroupResponse
    {
        $group = $this->groupRepository->getOneBy([GroupRepositoryInterface::FILTER_ID => $getGroupQuery->groupId]);

        return new GetGroupResponse($group);
    }
}
