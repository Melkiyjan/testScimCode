<?php

namespace Tenant\Application\SCIM\User\Application\UseCase\UpdateUser;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Tenant\Application\SCIM\Model\Meta;
use Tenant\Application\SCIM\User\Application\Model\EnterpriseUserModel;
use Tenant\Application\SCIM\User\Application\Model\NameModel;
use Tenant\Application\SCIM\User\Application\Model\PhoneModel;
use Tenant\Application\SCIM\User\Application\Model\UserModel;

/**
 * Class UpdateUserCommand
 */
class UpdateUserCommand
{
    public const SELECT = [
        UserModel::RESPONSE_SCHEMAS,
        UserModel::RESPONSE_META,
        UserModel::RESPONSE_EXTERNAL_ID,
        UserModel::RESPONSE_ID,
        UserModel::RESPONSE_USER_NAME,
        UserModel::RESPONSE_NAME,
        UserModel::RESPONSE_USER_ACTIVE,
        UserModel::RESPONSE_USER_DEPARTMENT,
        UserModel::RESPONSE_USER_PHONE,
        UserModel::RESPONSE_USER_POSITION,
        Meta::RESPONSE_LAST_MODIFIED,
        Meta::RESPONSE_RESOURCE_TYPE,
        Meta::RESPONSE_CREATED,
        NameModel::RESPONSE_NAME_FAMILY_NAME,
        NameModel::RESPONSE_NAME_GIVEN_NAME,
        NameModel::RESPONSE_NAME_FORMATTED,
        PhoneModel::RESPONSE_PHONE_TYPE,
        PhoneModel::RESPONSE_PHONE_VALUE,
        EnterpriseUserModel::RESPONSE_DEPARTMENT,
    ];

    /**
     * @var string[]
     *
     * @Assert\NotBlank()
     *
     * @Groups({"query"})
     */
    public array $schemas;

    /**
     * @Assert\Type("string")
     * @Assert\Length(max="36")
     *
     * @Groups({"query"})
     */
    public ?string $externalId = null;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Groups({"query"})
     */
    public string $userName;

    /**
     * @var NameModel
     *
     * @Assert\NotBlank()
     * @Assert\Valid()
     *
     * @Groups({"query"})
     */
    public NameModel $name;

    /**
     * @var string
     *
     * @Assert\Uuid()
     *
     * @Groups({"query"})
     */
    public string $id;

    public $active = true;
}
