<?php
namespace Bravo3\CloudCtrl\Enum\Aws;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * @method static VolumeType STANDARD()
 * @method static VolumeType PROVISIONED_IO()
 * @method static VolumeType EPHEMERAL()
 */
final class VolumeType extends AbstractEnumeration
{
    const STANDARD       = 'standard';
    const PROVISIONED_IO = 'io1';
    const EPHEMERAL      = '_ephemeral';
}
