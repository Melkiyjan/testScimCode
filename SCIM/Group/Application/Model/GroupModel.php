<?php

namespace Tenant\Application\SCIM\Group\Application\Model;

use Symfony\Component\Serializer\Annotation\Groups;
use Tenant\Application\SCIM\Model\Meta;
use Tenant\Application\SCIM\Schema;
use Tenant\Entity\Group;

/**
 * Class GroupModel
 */
class GroupModel
{
    public const RESPONSE_ID = 'group.id';
    public const RESPONSE_DISPLAY_NAME = 'group.displayName';
    public const RESPONSE_META = 'group.meta';
    public const RESPONSE_SCHEMAS = 'group.schemas';
    public const RESPONSE_EXTERNAL_ID = 'group.externalId';

    /**
     * @var Meta
     */
    private Meta $meta;

    /**
     * @var Group
     */
    private Group $originalGroup;

    /**
     * GroupModel constructor.
     *
     * @param Group $originalGroup
     */
    public function __construct(Group $originalGroup)
    {
        $this->meta = new Meta();
        $this->meta->resourceType = Meta::RESOURCE_TYPE_GROUP;
        $this->meta->created = $originalGroup->getCreatedAt()->format('Y-m-d\TH:i:s.000\Z');
        $this->meta->lastModified = $originalGroup->getUpdatedAt()->format('Y-m-d\TH:i:s.000\Z');

        $this->originalGroup = $originalGroup;
    }

    /**
     * @return string
     *
     * @Groups(GroupModel::RESPONSE_ID)
     */
    public function getId(): string
    {
        return (string) $this->originalGroup->getId();
    }

    /**
     * @return string
     *
     * @Groups(GroupModel::RESPONSE_DISPLAY_NAME)
     */
    public function getDisplayName(): string
    {
        return $this->originalGroup->getName();
    }

    /**
     * @Groups(GroupModel::RESPONSE_META)
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * @return string[]
     *
     * @Groups(GroupModel::RESPONSE_SCHEMAS)
     */
    public function getSchemas(): array
    {
        return [Schema::SCHEMA_CORE_GROUP];
    }

    /**
     * @return string|null
     *
     * @Groups(GroupModel::RESPONSE_EXTERNAL_ID)
     */
    public function getExternalId(): ?string
    {
        return $this->originalGroup->getExternalId();
    }
}
