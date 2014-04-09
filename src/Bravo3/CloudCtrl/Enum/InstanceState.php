<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Instance boot state
 */
final class InstanceState extends AbstractEnumeration
{
    const UNKNOWN    = 'UNKNOWN';
    const PENDING    = 'PENDING';
    const STARTING   = 'STARTING';
    const RUNNING    = 'RUNNING';
    const STOPPING   = 'STOPPING';
    const STOPPED    = 'STOPPED';
    const TERMINATED = 'TERMINATED';
}
