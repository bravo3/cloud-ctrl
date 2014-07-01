<?php
namespace Bravo3\CloudCtrl\Enum\Google;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * @method static InstanceStateCode PROVISIONING()
 * @method static InstanceStateCode RUNNING()
 * @method static InstanceStateCode STAGING()
 * @method static InstanceStateCode STOPPED()
 * @method static InstanceStateCode STOPPING()
 * @method static InstanceStateCode TERMINATED()
 */
final class InstanceStateCode extends AbstractEnumeration
{
    const PROVISIONING = 'PROVISIONING';
    const RUNNING      = 'RUNNING';
    const STAGING      = 'STAGING';
    const STOPPED      = 'STOPPED';
    const STOPPING     = 'STOPPING';
    const TERMINATED   = 'TERMINATED';
}
