<?php

namespace Tenant\Application\SCIM\Group\Application\UseCase\DeleteGroup;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateGroupCommand
 */
class DeleteGroupCommand
{
    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\Length(max="36")
     * @Assert\Uuid()
     *
     * @Groups({"query"})
     */
    public string $id;

    /**
     * DeleteGroupCommand constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
