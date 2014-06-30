<?php
namespace Bravo3\CloudCtrl\Enum\Aws;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * @method static InstanceStateCode PENDING()
 * @method static InstanceStateCode RUNNING()
 * @method static InstanceStateCode SHUTTING_DOWN()
 * @method static InstanceStateCode TERMINATED()
 * @method static InstanceStateCode STOPPING()
 * @method static InstanceStateCode STOPPED()
 */
final class InstanceStateCode extends AbstractEnumeration
{
    const PENDING       = 0;
    const RUNNING       = 16;
    const SHUTTING_DOWN = 32;
    const TERMINATED    = 48;
    const STOPPING      = 64;
    const STOPPED       = 80;
} 