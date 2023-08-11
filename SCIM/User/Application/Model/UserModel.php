<?php

namespace Tenant\Application\SCIM\User\Application\Model;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Tenant\Application\SCIM\Model\Meta;
use Tenant\Application\SCIM\Schema;
use Tenant\Entity\User;

/**
 * Class UserModel
 */
class UserModel
{
    public const RESPONSE_ID = 'user.id';
    public const RESPONSE_NAME = 'user.name';
    public const RESPONSE_META = 'user.meta';
    public const RESPONSE_SCHEMAS = 'user.schemas';
    public const RESPONSE_EXTERNAL_ID = 'user.externalId';
    public const RESPONSE_USER_NAME = 'user.userName';
    public const RESPONSE_USER_ACTIVE = 'user.active';
    public const RESPONSE_USER_DEPARTMENT = 'user.department';
    public const RESPONSE_USER_PHONE = 'user.phone';
    public const RESPONSE_USER_POSITION = 'user.position';

    /**
     * @var Meta
     */
    private Meta $meta;

    /**
     * @var NameModel
     */
    private NameModel $name;

    /**
     * @var User
     */
    private User $originalUser;

    /**
     * UserModel constructor.
     *
     * @param User $originalUser
     */
    public function __construct(User $originalUser)
    {
        $this->originalUser = $originalUser;

        $this->name = new NameModel();
        $this->name->familyName = $this->originalUser->getLastName();
        $this->name->givenName = $this->originalUser->getFirstName();
        $this->name->formatted = $this->name->givenName.' '.$this->name->familyName;

        $this->meta = new Meta();
        $this->meta->resourceType = Meta::RESOURCE_TYPE_USER;
        $this->meta->created = $this->originalUser->getCreatedAt()->format('Y-m-d\TH:i:s.000\Z');
        $this->meta->lastModified = $this->originalUser->getUpdatedAt()->format('Y-m-d\TH:i:s.000\Z');
    }

    /**
     * @return string
     *
     * @Groups(UserModel::RESPONSE_ID)
     */
    public function getId(): string
    {
        return (string) $this->originalUser->getId();
    }

    /**
     * @Groups(UserModel::RESPONSE_META)
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * @return string[]
     *
     * @Groups(UserModel::RESPONSE_SCHEMAS)
     */
    public function getSchemas(): array
    {
        return [Schema::SCHEMA_CORE_USER];
    }

    /**
     * @return string|null
     *
     * @Groups(UserModel::RESPONSE_EXTERNAL_ID)
     */
    public function getExternalId(): ?string
    {
        return $this->originalUser->getExternalId();
    }

    /**
     * @Groups(UserModel::RESPONSE_NAME)
     */
    public function getName(): NameModel
    {
        return $this->name;
    }

    /**
     * @return string
     *
     * @Groups(UserModel::RESPONSE_USER_NAME)
     */
    public function getUserName(): string
    {
        return $this->originalUser->getUsername();
    }

    /**
     * @return bool
     *
     * @Groups(UserModel::RESPONSE_USER_ACTIVE)
     */
    public function getActive(): bool
    {
        return !$this->originalUser->isDeactivated();
    }

    /**
     * @return string|null
     *
     * @Groups(UserModel::RESPONSE_USER_POSITION)
     */
    public function getTitle(): ?string
    {
        if (!$this->originalUser->getPosition()) {
            return null;
        }

        return  $this->originalUser->getPosition();
    }

    /**
     * @return string[]
     *
     * @Groups(UserModel::RESPONSE_USER_PHONE)
     */
    public function getPhoneNumbers(): ?array
    {
        if (!$this->originalUser->getPhone()) {
            return null;
        }

        $phone = new PhoneModel();
        $phone->value = $this->originalUser->getPhone();

        return [$phone];
    }

    /**
     * @Groups(UserModel::RESPONSE_USER_DEPARTMENT)
     *
     * @SerializedName(Schema::SCHEMA_ENTERPRISE)
     */
    public function getDepartment(): ?EnterpriseUserModel
    {
        $enterpriseUser = new EnterpriseUserModel();
        $enterpriseUser->department = $this->originalUser->getDepartment();

        return $enterpriseUser;
    }
}
