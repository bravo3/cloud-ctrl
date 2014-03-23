<?php
namespace Bravo3\CloudCtrl\Interfaces\Instance;

/**
 * An instance with a mandatory name
 */
trait NamedInstanceTrait
{
    protected $instance_name = null;

    /**
     * Set the instance name
     *
     * @param string $name
     * @return $this
     */
    public function setInstanceName($name)
    {
        $this->instance_name = $name;
        return $this;
    }

    /**
     * Get the instance name
     *
     * @return string
     */
    public function getInstanceName()
    {
        return $this->instance_name;
    }

} 