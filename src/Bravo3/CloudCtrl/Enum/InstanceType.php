<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Provisioning instance types
 *
 * Not final - you should allow for unknown instance types
 */
final class InstanceType extends AbstractEnumeration
{
    const ONDEMAND = 'ONDEMAND';
    const SPOT     = 'SPOT';
    const RESERVED = 'RESERVED';

    /**
     * Get a list of all valid instance types
     *
     * Use InstanceType::members() instead
     *
     * @return string[]
     * @deprecated
     */
    public static function getValidInstanceTypes()
    {
        return self::members();
    }

}
