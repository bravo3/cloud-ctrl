<?php
namespace Bravo3\CloudCtrl\Reports\Traits;

use Bravo3\CloudCtrl\Collections\InstanceCollection;
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
     * Set instances as an array
     *
     * @param InstanceCollection|InstanceInterface[] $instances
     * @return $this
     */
    public function setInstances($instances)
    {
        $this->instances = ($instances instanceof InstanceCollection) ? $instances->toArray() : $instances;
        return $this;
    }

    /**
     * Get a collection of all instances
     *
     * @return InstanceCollection
     */
    public function getInstances()
    {
        return new InstanceCollection($this->instances);
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