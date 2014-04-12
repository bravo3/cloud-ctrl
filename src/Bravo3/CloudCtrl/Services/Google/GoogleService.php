<?php
namespace Bravo3\CloudCtrl\Services\Google;

use Bravo3\CloudCtrl\Services\CloudService;

/**
 * Google Cloud
 */
class GoogleService extends CloudService
{
    /**
     * Create the instance manager
     */
    protected function createInstanceManager()
    {
        $this->instance_manager = new GoogleInstanceManager($this);
    }

    /**
     * Create a load balancer manager
     */
    protected function createLoadBalancerManager()
    {
        // TODO: Implement createLoadBalancerManager() method.
    }

    /**
     * Create a resource manager to control instance resources
     */
    protected function createResourceManager()
    {
        // TODO: Implement createResourceManager() method.
    }

    /**
     * Create an object store
     */
    protected function createObjectStore()
    {
        // TODO: Implement createObjectStore() method.
    }


}
