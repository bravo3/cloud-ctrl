<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * @method static Redundancy STANDARD()
 * @method static Redundancy REDUCED()
 */
class Redundancy extends AbstractEnumeration
{
    const STANDARD = 'STANDARD';
    const REDUCED = 'REDUCED';
}
 