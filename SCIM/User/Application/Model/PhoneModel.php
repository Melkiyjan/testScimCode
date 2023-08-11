<?php

namespace Tenant\Application\SCIM\User\Application\Model;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PhoneModel
 */
class PhoneModel
{
    public const RESPONSE_PHONE_TYPE = 'phone.type';
    public const RESPONSE_PHONE_VALUE = 'phone.value';

    public const PHONE_TYPE_WORK = 'work';

    /**
     * @var string
     *
     * @Assert\Type("string")
     *
     * @Groups({PhoneModel::RESPONSE_PHONE_TYPE, "query"})
     */
    public string $type = self::PHONE_TYPE_WORK;

    /**
     * @var string
     *
     * @Assert\Type("string")
     *
     * @Groups({PhoneModel::RESPONSE_PHONE_VALUE, "query"})
     */
    public string $value;
}
