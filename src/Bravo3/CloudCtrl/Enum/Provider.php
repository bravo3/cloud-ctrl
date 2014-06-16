<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Cloud-hosting providers
 *
 * @method static Provider AWS()
 * @method static Provider GOOGLE()
 * @method static Provider AZURE()
 */
final class Provider extends AbstractEnumeration
{
    const AWS    = 'AWS';
    const GOOGLE = 'GOOGLE';
    const AZURE  = 'AZURE';
}
