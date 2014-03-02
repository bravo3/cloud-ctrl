<?php
namespace NovaTek\CloudCtrl\Services\Aws;

use NovaTek\CloudCtrl\Filters\InstanceFilter;
use NovaTek\CloudCtrl\Schema\InstanceSchema;
use NovaTek\CloudCtrl\Services\Common\InstanceManager;

/**
 * Amazon Web Services instance manager for EC2
 */
class AwsInstanceManager extends InstanceManager
{
    public function createInstances($count, InstanceSchema $schema)
    {
        // TODO: Implement createInstances() method.
    }

    public function startInstances(InstanceFilter $instances)
    {
        // TODO: Implement startInstances() method.
    }

    public function stopInstances(InstanceFilter $instances)
    {
        // TODO: Implement stopInstances() method.
    }

    public function terminateInstances(InstanceFilter $instances)
    {
        // TODO: Implement terminateInstances() method.
    }

    public function describeInstances(InstanceFilter $instances)
    {
        // TODO: Implement describeInstances() method.
    }

    public function setInstanceTags($tags, InstanceFilter $instances)
    {
        // TODO: Implement setInstanceTags() method.
    }


}
 