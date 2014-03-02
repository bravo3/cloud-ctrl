<?php
namespace NovaTek\CloudCtrl\Services\Common;

use NovaTek\CloudCtrl\Entity\LoadBalancer;

/**
 * Responsible for all load balancer actions
 */
abstract class LoadBalancerManager extends CloudServiceAwareComponent
{

    /**
     * Create a new load balancer
     *
     * @return mixed
     */
    abstract public function createLoadBalancer(LoadBalancer $lb, $instances = []);

    /**
     * Completely remove a load balancer
     *
     * @param LoadBalancer $lb
     * @return mixed
     */
    abstract public function removeLoadBalancer(LoadBalancer $lb);

    /**
     * Get the state of a load balancer including all of its instance registrations
     *
     * @return mixed
     */
    abstract public function describeLoadBalancer();

    abstract public function registerInstances();

    abstract public function deregisterInstances();




}
 