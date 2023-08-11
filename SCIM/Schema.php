<?php

namespace Tenant\Application\SCIM;

/**
 * Class Schema
 */
class Schema
{
    public const SCHEMA_CORE_USER = 'urn:ietf:params:scim:schemas:core:2.0:User';
    public const SCHEMA_LIST_RESPONSE = 'urn:ietf:params:scim:api:messages:2.0:ListResponse';
    public const SCHEMA_PATCH_OP = 'urn:ietf:params:scim:api:messages:2.0:PatchOp';
    public const SCHEMA_CORE_GROUP = 'urn:ietf:params:scim:schemas:core:2.0:Group';
    public const SCHEMA_ENTERPRISE = 'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User';
    public const SCHEMA_ENTERPRISE_DEPARTMENT = 'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User:department';
}
