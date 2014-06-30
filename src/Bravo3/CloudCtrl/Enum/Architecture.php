<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * @method static Architecture X86_64()
 * @method static Architecture I64()
 * @method static Architecture I386()
 */
final class Architecture extends AbstractEnumeration
{
    const X86_64 = 'x86_64';
    const I64    = 'I64';
    const I386   = 'i386';
}
