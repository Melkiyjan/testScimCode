<?php

namespace Tenant\Application\SCIM\User\Application\Model;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class NameModel
 */
class NameModel
{
    public const RESPONSE_NAME_FAMILY_NAME = 'name.familyName';
    public const RESPONSE_NAME_GIVEN_NAME = 'name.givenName';
    public const RESPONSE_NAME_FORMATTED = 'name.formatted';

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\NotBlank()
     *
     * @Groups({NameModel::RESPONSE_NAME_FAMILY_NAME, "query"})
     */
    public string $familyName;

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\NotBlank()
     *
     * @Groups({NameModel::RESPONSE_NAME_GIVEN_NAME, "query"})
     */
    public string $givenName;

    /**
     * @Groups(NameModel::RESPONSE_NAME_FORMATTED)
     */
    public ?string $formatted = null;
}
