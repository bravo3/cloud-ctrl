<?php
namespace NovaTek\CloudCtrl\Enum;

/**
 * Provisioning instance types
 */
class InstanceType
{
    const ONDEMAND = 'ONDEMAND';
    const SPOT = 'SPOT';
    const RESERVED = 'RESERVED';

    /**
     * Get a list of all valid instance types
     *
     * @return string[]
     */
    public static function getValidInstanceTypes() {
        return [self::ONDEMAND, self::SPOT, self::RESERVED];
    }

}
