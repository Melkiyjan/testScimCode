<?php

namespace Tenant\Application\SCIM\User\Application\UseCase\DeleteUser;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteUserCommand
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
    public string $userId;
}
