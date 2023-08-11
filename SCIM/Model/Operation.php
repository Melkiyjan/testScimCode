<?php


namespace Tenant\Application\SCIM\Model;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Operation
 */
class Operation
{
    const OP_ADD = 'add';
    const OP_REMOVE = 'remove';
    const OP_REPLACE = 'replace';

    const PATH_MEMBERS = 'members';

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\NotBlank()
     *
     * @Groups({"query"})
     */
    public $op;

    /**
     * @var ?string
     *
     * @Assert\Type("string")
     *
     * @Groups({"query"})
     */
    public $path = null;

    /**
     * @var mixed
     */
    public $value;
}
