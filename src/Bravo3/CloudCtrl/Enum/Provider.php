<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Cloud-hosting providers
 *
 * TODO: this list should grow - is an enumeration really right?
 */
class Provider extends AbstractEnumeration
{
    const AWS    = 'AWS';
    const GOOGLE = 'GOOGLE';
    const AZURE  = 'AZURE';
}
