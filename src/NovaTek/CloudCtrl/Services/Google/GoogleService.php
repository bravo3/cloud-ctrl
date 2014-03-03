<?php
namespace NovaTek\CloudCtrl\Services\Google;

use NovaTek\CloudCtrl\Services\CloudService;

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
        $this->instanceManager = new GoogleInstanceManager($this);
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


}
