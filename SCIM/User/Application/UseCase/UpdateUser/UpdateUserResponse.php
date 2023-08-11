<?php


namespace Tenant\Application\SCIM\User\Application\UseCase\UpdateUser;

use Tenant\Application\SCIM\User\Application\Model\UserModel;
use Tenant\Entity\User;

/**
 * Class UpdateUserResponse
 */
class UpdateUserResponse extends UserModel
{
    /**
     * UpdateUserResponse constructor.
     *
     * @param User $originalUser
     */
    public function __construct(User $originalUser)
    {
        parent::__construct($originalUser);
    }
}
