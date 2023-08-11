<?php

namespace Tenant\Application\SCIM\Group\Application\UseCase\UpdateGroup;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Tenant\Application\SCIM\Schema;

/**
 * Class PatchGroupCommand
 */
class UpdateGroupCommand
{
    /**
     * @var string[]
     *
     * @Assert\Type("array")
     * @Assert\All(
     *   @Assert\Choice({Schema::SCHEMA_PATCH_OP})
     * )
     * @Assert\NotBlank()
     *
     * @Groups({"query"})
     */
    public array $schemas;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     *
     * @Groups({"query"})
     */
    public string $displayName;

    /**
     * @var string[]
     *
     * @Assert\Type("array")
     *
     * @Groups({"query"})
     */
    public array $members;

    /**
     * @var string
     *
     * @Assert\Uuid()
     *
     * @Groups({"query"})
     */
    public string $id;
}
