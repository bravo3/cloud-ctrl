<?php
namespace NovaTek\CloudCtrl\Enum;

/**
 * Instance tenancy types
 */
class Tenancy
{
    const VPC = 'vpc';
    const DEDICATED = 'dedicated';

    /**
     * Get a list of all valid tenancy types
     *
     * @return string[]
     */
    public static function getValidTenancyTypes() {
        return [self::VPC, self::DEDICATED];
    }
}
 