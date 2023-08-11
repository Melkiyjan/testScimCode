<?php


namespace Tenant\Application\SCIM\User\Application\Service;

use Framework\Exception\JsonException;

/**
 * Class ScimUtility
 */
final class ScimUtility
{
    /**
     * @param $value
     *
     * @return bool
     *
     * @throws
     */
    public static function convertActiveValueToBool($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        switch ($value) {
            case '0':
            case 'False':
                return false;
            case '1':
            case 'True':
                return true;
            default:
                throw  new JsonException('Property action should be a boolean or string: "0", "False", "1", "True"');
        }
    }
}
