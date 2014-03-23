<?php
namespace Bravo3\CloudCtrl\Reports\Traits;

use Bravo3\CloudCtrl\Interfaces\Instance\InstanceInterface;

/**
 * Contains a list of instances
 */
trait InstanceListTrait
{

    /**
     * @var InstanceInterface[]
     */
    protected $instances = [];

    /**
     * Set Instances
     *
     * @param InstanceInterface[] $instances
     * @return $this
     */
    public function setInstances($instances)
    {
        $this->instances = $instances;
        return $this;
    }

    /**
     * Get Instances
     *
     * @return InstanceInterface[]
     */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
     * Add an instance to the result stack
     *
     * @param InstanceInterface $instance
     * @return $this
     */
    public function addInstance(InstanceInterface $instance)
    {
        $this->instances[] = $instance;
        return $this;
    }
} 