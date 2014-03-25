<?php
namespace Bravo3\CloudCtrl\Interfaces\Instance;

use Bravo3\CloudCtrl\Interfaces\IPAddress\IPAddressInterface;
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
     * @param string $state
     * @return $this
     */
    public function setInstanceState($state);

    /**
     * Get the instance state
     *
     * @return string
     */
    public function getInstanceState();


    /**
     * Set Architecture
     *
     * @param string $architecture
     * @return $this
     */
    public function setArchitecture($architecture);

    /**
     * Get Architecture
     *
     * @return string
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
     * @param IPAddressInterface $private_address
     * @return $this
     */
    public function setPrivateAddress($private_address);

    /**
     * Get PrivateAddress
     *
     * @return IPAddressInterface
     */
    public function getPrivateAddress();

    /**
     * Set PublicAddress
     *
     * @param IPAddressInterface $public_address
     * @return $this
     */
    public function setPublicAddress($public_address);

    /**
     * Get PublicAddress
     *
     * @return IPAddressInterface
     */
    public function getPublicAddress();



}
 