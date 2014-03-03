<?php
namespace NovaTek\CloudCtrl\Services\Google;

use NovaTek\CloudCtrl\Filters\InstanceFilter;
use NovaTek\CloudCtrl\Reports\InstanceProvisionReport;
use NovaTek\CloudCtrl\Schema\InstanceSchema;
use NovaTek\CloudCtrl\Services\Common\InstanceManager;

/**
 * 
 */
class GoogleInstanceManager extends InstanceManager
{
    /**
     * Create new instances
     *
     * @param int            $count
     * @param InstanceSchema $schema
     * @return InstanceProvisionReport
     */
    public function createInstances($count, InstanceSchema $schema)
    {
        $client = new \Google_Client();

        $client->setApplicationName("Test");
        $client->setDeveloperKey("748692468786.apps.googleusercontent.com");

        //$client->getAccessToken();

        $compute = new \Google_Service_Compute($client);

        return $compute->instances->listInstances("Test", "us-central1");
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
 