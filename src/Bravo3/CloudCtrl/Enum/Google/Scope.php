<?php
namespace Bravo3\CloudCtrl\Enum\Google;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * @method static Scope COMPUTE_READ()
 * @method static Scope COMPUTE_WRITE()
 */
class Scope extends AbstractEnumeration
{
    const COMPUTE_READ  = \Google_Service_Compute::COMPUTE_READONLY;
    const COMPUTE_WRITE = \Google_Service_Compute::COMPUTE;
}
 