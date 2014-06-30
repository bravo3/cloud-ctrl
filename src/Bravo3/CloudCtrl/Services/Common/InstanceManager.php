<?php
namespace Bravo3\CloudCtrl\Services\Common;

use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Interfaces\Instance\InstanceInterface;
use Bravo3\CloudCtrl\Reports\ImageCreateReport;
use Bravo3\CloudCtrl\Reports\InstanceListReport;
use Bravo3\CloudCtrl\Reports\InstanceProvisionReport;
use Bravo3\CloudCtrl\Reports\SuccessReport;
use Bravo3\CloudCtrl\Schema\ImageSchema;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
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

    /**
     * Start a set of stopped instances
     *
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    abstract public function startInstances(InstanceFilter $instances);

    /**
     * Stop a set of running instances
     *
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    abstract public function stopInstances(InstanceFilter $instances);

    /**
     * Restart a set of instances
     *
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    abstract public function restartInstances(InstanceFilter $instances);

    /**
     * Terminate a set of instances
     *
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    abstract public function terminateInstances(InstanceFilter $instances);

    /**
     * Get a list of instances
     *
     * @param InstanceFilter $instances
     * @return InstanceListReport
     */
    abstract public function describeInstances(InstanceFilter $instances);

    /**
     * Set tags for a set of instances
     *
     * @param array          $tags
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    abstract public function setInstanceTags(array $tags, InstanceFilter $instances);


    /**
     * Start the process of saving a machine image
     *
     * @param string      $instance_id
     * @param ImageSchema $image_schema
     * @return ImageCreateReport
     */
    abstract public function saveImage($instance_id, ImageSchema $image_schema);

    /**
     * Log the creation of an instance to the logger
     *
     * @param int               $index
     * @param InstanceInterface $instance
     * @param string            $name
     * @param string            $notes
     */
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
