<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Instance tenancy types
 *
 * Allow for unknown tenancies
 */
class Tenancy extends AbstractEnumeration
{
    const VPC       = 'VPC';
    const DEDICATED = 'DEDICATED';

    /**
     * Get a list of all valid tenancy types
     *
     * Use Tenancy::members() instead
     *
     * @return string[]
     * @deprecated
     */
    public static function getValidTenancyTypes()
    {
        return self::members();
    }
}
 