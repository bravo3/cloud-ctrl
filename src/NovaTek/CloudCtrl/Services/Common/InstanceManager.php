<?php
namespace NovaTek\CloudCtrl\Services\Common;

use NovaTek\CloudCtrl\Filters\InstanceFilter;
use NovaTek\CloudCtrl\Schema\InstanceSchema;

/**
 * Responsible for starting and stopping instances
 */
abstract class InstanceManager extends CloudServiceAwareComponent
{

    abstract public function createInstances($count, InstanceSchema $schema);

    abstract public function startInstances(InstanceFilter $instances);

    abstract public function stopInstances(InstanceFilter $instances);

    abstract public function terminateInstances(InstanceFilter $instances);

    abstract public function describeInstances(InstanceFilter $instances);

    abstract public function setInstanceTags($tags, InstanceFilter $instances);

}
