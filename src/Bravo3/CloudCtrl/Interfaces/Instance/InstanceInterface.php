<?php
namespace Bravo3\CloudCtrl\Interfaces\Instance;

/**
 * Represents an instance
 */
interface InstanceInterface
{

    /**
     * Set InstanceId
     *
     * @param string $instance_id
     * @return $this
     */
    public function setInstanceId($instance_id);

    /**
     * Get InstanceId
     *
     * @return string
     */
    public function getInstanceId();

    /**
     * Set Region
     *
     * @param string $region
     * @return $this
     */
    public function setRegion($region);

    /**
     * Get Region
     *
     * @return string
     */
    public function getRegion();

    /**
     * Set Zone
     *
     * @param string $zone
     * @return $this
     */
    public function setZone($zone);

    /**
     * Get Zone
     *
     * @return string
     */
    public function getZone();

    /**
     * The name of the cloud provider
     *
     * @see \Bravo3\CloudCtrl\Enum\Provider
     * @return string
     */
    public function getProvider();
}
 