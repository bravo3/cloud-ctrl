<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * NB: not final - allow for unknown types
 */
class Architecture extends AbstractEnumeration
{
    const X86_64 = 'x86_64';
    const I64    = 'I64';
    const I386   = 'i386';
}
