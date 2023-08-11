<?php

namespace Tenant\Application\SCIM\User\Application\Model;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EnterpriseUserModel
 */
class EnterpriseUserModel
{
    public const RESPONSE_DEPARTMENT = 'enterpriseUser.department';

    /**
     * @var string|null
     *
     * @Assert\Type("string")
     *
     * @Groups({EnterpriseUserModel::RESPONSE_DEPARTMENT, "query"})
     */
    public ?string $department = null;
}
