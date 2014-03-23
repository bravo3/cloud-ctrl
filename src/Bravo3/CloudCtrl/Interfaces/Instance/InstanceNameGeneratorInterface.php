<?php
namespace Bravo3\CloudCtrl\Interfaces\Instance;

use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;
use Bravo3\CloudCtrl\Schema\InstanceSchema;

/**
 * Creates names for instances - only used by providers that support instance names
 */
interface InstanceNameGeneratorInterface
{

    /**
     * Generate a new instance name
     *
     * @param InstanceSchema $schema   Schema used to create this instance
     * @param ZoneInterface  $zone     The selected zone
     * @param integer        $sequence Zero-indexed instance number of the create wad
     * @return string
     */
    public function getInstanceName(InstanceSchema $schema, ZoneInterface $zone, $sequence);

}
 