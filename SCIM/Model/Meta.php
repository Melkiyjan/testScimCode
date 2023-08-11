<?php


namespace Tenant\Application\SCIM\Model;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Meta
 */
class Meta
{
    public const RESPONSE_RESOURCE_TYPE = 'meta.resourceType';
    public const RESPONSE_CREATED = 'meta.created';
    public const RESPONSE_LAST_MODIFIED = 'meta.lastModified';

    const RESOURCE_TYPE_GROUP = 'Group';
    const RESOURCE_TYPE_USER = 'User';

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\Choice({
     *     Meta::RESOURCE_TYPE_GROUP
     * })
     *
     * @Groups({Meta::RESPONSE_RESOURCE_TYPE, "query"})
     */
    public string $resourceType;

    /**
     * @var string
     *
     * @Groups(Meta::RESPONSE_CREATED)
     */
    public string $created;

    /**
     * @var string
     *
     * @Groups(Meta::RESPONSE_LAST_MODIFIED)
     */
    public string $lastModified;
}
