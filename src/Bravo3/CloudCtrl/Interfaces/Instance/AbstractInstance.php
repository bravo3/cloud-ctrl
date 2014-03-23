<?php
namespace Bravo3\CloudCtrl\Interfaces\Instance;


/**
 * Represents an instance
 */
abstract class AbstractInstance implements InstanceInterface
{

    /**
     * @var string
     */
    protected $instance_id;

    /**
     * @var string
     */
    protected $region;

    /**
     * @var string
     */
    protected $zone;

    // TODO: instance state - needs abstract enumeration

    // --

    /**
     * Set InstanceId
     *
     * @param string $instance_id
     * @return $this
     */
    public function setInstanceId($instance_id)
    {
        $this->instance_id = $instance_id;
        return $this;
    }

    /**
     * Get InstanceId
     *
     * @return string
     */
    public function getInstanceId()
    {
        return $this->instance_id;
    }

    /**
     * Set Region
     *
     * @param string $region
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get Region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set Zone
     *
     * @param string $zone
     * @return $this
     */
    public function setZone($zone)
    {
        $this->zone = $zone;
        return $this;
    }

    /**
     * Get Zone
     *
     * @return string
     */
    public function getZone()
    {
        return $this->zone;
    }


}
 