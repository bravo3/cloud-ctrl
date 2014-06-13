<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Instance boot state
 *
 * @method static InstanceState UNKNOWN()
 * @method static InstanceState PENDING()
 * @method static InstanceState STARTING()
 * @method static InstanceState RUNNING()
 * @method static InstanceState STOPPING()
 * @method static InstanceState STOPPED()
 * @method static InstanceState TERMINATING()
 * @method static InstanceState TERMINATED()
 */
final class InstanceState extends AbstractEnumeration
{
    const UNKNOWN     = 'UNKNOWN';
    const PENDING     = 'PENDING';
    const STARTING    = 'STARTING';
    const RUNNING     = 'RUNNING';
    const STOPPING    = 'STOPPING';
    const STOPPED     = 'STOPPED';
    const TERMINATING = 'TERMINATING';
    const TERMINATED  = 'TERMINATED';
}
