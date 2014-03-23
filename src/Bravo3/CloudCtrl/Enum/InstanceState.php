<?php
namespace Bravo3\CloudCtrl\Enum;

/**
 * Instance boot state
 */
class InstanceState
{
    const UNKNOWN    = 'UNKNOWN';
    const PENDING    = 'PENDING';
    const STARTING   = 'STARTING';
    const RUNNING    = 'RUNNING';
    const STOPPING   = 'STOPPING';
    const STOPPED    = 'STOPPED';
    const TERMINATED = 'TERMINATED';
}
