<?php

namespace Tenant\Application\SCIM\Group\Application\UseCase\GetGroup;

use Tenant\Application\SCIM\Group\Application\Model\GroupModel;
use Tenant\Entity\Group;

/**
 * Class GetGroupResponse
 */
class GetGroupResponse extends GroupModel
{
    /**
     * GetGroupResponse constructor.
     *
     * @param Group $originalGroup
     */
    public function __construct(Group $originalGroup)
    {
        parent::__construct($originalGroup);
    }
}
