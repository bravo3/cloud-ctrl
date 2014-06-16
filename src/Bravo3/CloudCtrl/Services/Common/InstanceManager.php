<?php
namespace Bravo3\CloudCtrl\Services\Common;

use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Interfaces\Instance\InstanceInterface;
use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;
use Bravo3\CloudCtrl\Reports\InstanceListReport;
use Bravo3\CloudCtrl\Reports\InstanceProvisionReport;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Responsible for starting and stopping instances
 */
abstract class InstanceManager extends CloudServiceAwareComponent
{
    /**
     * Create new instances
     *
     * @param int            $count
     * @param InstanceSchema $schema
     * @return InstanceProvisionReport
     */
    abstract public function createInstances($count, InstanceSchema $schema);

    abstract public function startInstances(InstanceFilter $instances);

    abstract public function stopInstances(InstanceFilter $instances);

    abstract public function restartInstances(InstanceFilter $instances);

    abstract public function terminateInstances(InstanceFilter $instances);

    /**
     * Get a list of instances
     *
     * @param InstanceFilter $instances
     * @return InstanceListReport
     */
    abstract public function describeInstances(InstanceFilter $instances);

    abstract public function setInstanceTags($tags, InstanceFilter $instances);


    protected function logCreateInstance($index, InstanceInterface $instance, $name = '<no name>', $notes = '')
    {
        $zone = $instance->getZone();

        $this->info(
            "Created ".$instance->getProvider()." instance #".$index." in zone [".
            ($zone ? $zone->getZoneName() : '<unknown>')."] with name [".
            $name."] - instance ID [".$instance->getInstanceId()."]".($notes ? (': '.$notes) : '')
        );
    }

}
