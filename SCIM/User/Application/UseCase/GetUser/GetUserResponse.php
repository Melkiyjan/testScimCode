<?php

namespace Tenant\Application\SCIM\User\Application\UseCase\GetUser;

use Tenant\Application\SCIM\User\Application\Model\UserModel;
use Tenant\Entity\User;

/**
 * Class GetUserResponse
 */
class GetUserResponse extends UserModel
{
    /**
     * GetUserResponse constructor.
     *
     * @param User $originalUser
     */
    public function __construct(User $originalUser)
    {
        parent::__construct($originalUser);
    }
}
