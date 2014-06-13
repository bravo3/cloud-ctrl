<?php
namespace Bravo3\CloudCtrl\Interfaces\Instance;

use Bravo3\CloudCtrl\Enum\Architecture;
use Bravo3\CloudCtrl\Enum\InstanceState;
use Bravo3\CloudCtrl\Interfaces\IpAddress\IpAddressInterface;
use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;

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
     * Set Zone
     *
     * @param ZoneInterface $zone
     * @return $this
     */
    public function setZone(ZoneInterface $zone);

    /**
     * Get Zone
     *
     * @return ZoneInterface
     */
    public function getZone();

    /**
     * The name of the cloud provider
     *
     * @see \Bravo3\CloudCtrl\Enum\Provider
     * @return string
     */
    public function getProvider();

    /**
     * Set the instance state
     *
     * @param InstanceState $instance_state
     * @return $this
     */
    public function setInstanceState(InstanceState $instance_state);

    /**
     * Get the instance state
     *
     * @return InstanceState
     */
    public function getInstanceState();


    /**
     * Set Architecture
     *
     * @param Architecture $architecture
     * @return $this
     */
    public function setArchitecture(Architecture $architecture);

    /**
     * Get Architecture
     *
     * @return Architecture
     */
    public function getArchitecture();

    /**
     * Set the ID of the base image
     *
     * @param string $image_id
     * @return $this
     */
    public function setImageId($image_id);

    /**
     * Get the ID of the base image
     *
     * @return string
     */
    public function getImageId();

    /**
     * Set PrivateAddress
     *
     * @param IpAddressInterface $private_address
     * @return $this
     */
    public function setPrivateAddress(IpAddressInterface $private_address);

    /**
     * Get PrivateAddress
     *
     * @return IpAddressInterface
     */
    public function getPrivateAddress();

    /**
     * Set PublicAddress
     *
     * @param IpAddressInterface $public_address
     * @return $this
     */
    public function setPublicAddress(IpAddressInterface $public_address);

    /**
     * Get PublicAddress
     *
     * @return IpAddressInterface
     */
    public function getPublicAddress();

    /**
     * Set instance size
     *
     * @param string $instance_size
     * @return $this
     */
    public function setInstanceSize($instance_size);

    /**
     * Get instance size
     *
     * @return string
     */
    public function getInstanceSize();

    /**
     * Set tags
     *
     * @param array $tags
     * @return $this
     */
    public function setTags(array $tags);

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags();

}
 