<?php

namespace Tenant\Application\SCIM\Group\Application\UseCase\GetGroup;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Tenant\Application\SCIM\Group\Application\Model\GroupModel;
use Tenant\Application\SCIM\Model\Meta;

/**
 * Class GetGroupQuery
 */
class GetGroupQuery
{
    const SELECT = [
        GroupModel::RESPONSE_SCHEMAS,
        GroupModel::RESPONSE_ID,
        GroupModel::RESPONSE_EXTERNAL_ID,
        GroupModel::RESPONSE_META,
        GroupModel::RESPONSE_DISPLAY_NAME,
        Meta::RESPONSE_LAST_MODIFIED,
        Meta::RESPONSE_RESOURCE_TYPE,
        Meta::RESPONSE_CREATED,
    ];

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\Length(max="36")
     * @Assert\Uuid()
     *
     * @Groups({"query"})
     */
    public string $groupId;
}
