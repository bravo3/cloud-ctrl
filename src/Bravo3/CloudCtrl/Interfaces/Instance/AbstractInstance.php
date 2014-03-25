<?php
namespace Bravo3\CloudCtrl\Interfaces\Instance;

use Bravo3\CloudCtrl\Interfaces\IPAddress\IPAddressInterface;
use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;


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
     * @var ZoneInterface
     */
    protected $zone;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $image_id;

    /**
     * @var IpAddressInterface
     */
    protected $public_address;

    /**
     * @var IpAddressInterface
     */
    protected $private_address;

    /**
     * @var string
     */
    protected $architecture;

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
     * Set Zone
     *
     * @param ZoneInterface $zone
     * @return $this
     */
    public function setZone(ZoneInterface $zone)
    {
        $this->zone = $zone;
        return $this;
    }

    /**
     * Get Zone
     *
     * @return ZoneInterface
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set the instance state
     *
     * @param string $state
     * @return $this
     */
    public function setInstanceState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get the instance state
     *
     * @return string
     */
    public function getInstanceState()
    {
        return $this->state;
    }

    /**
     * Set Architecture
     *
     * @param string $architecture
     * @return $this
     */
    public function setArchitecture($architecture)
    {
        $this->architecture = $architecture;
        return $this;
    }

    /**
     * Get Architecture
     *
     * @return string
     */
    public function getArchitecture()
    {
        return $this->architecture;
    }

    /**
     * Set the ID of the base image
     *
     * @param string $image_id
     * @return $this
     */
    public function setImageId($image_id)
    {
        $this->image_id = $image_id;
        return $this;
    }

    /**
     * Get the ID of the base image
     *
     * @return string
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * Set PrivateAddress
     *
     * @param IPAddressInterface $private_address
     * @return $this
     */
    public function setPrivateAddress($private_address)
    {
        $this->private_address = $private_address;
        return $this;
    }

    /**
     * Get PrivateAddress
     *
     * @return IPAddressInterface
     */
    public function getPrivateAddress()
    {
        return $this->private_address;
    }

    /**
     * Set PublicAddress
     *
     * @param IPAddressInterface $public_address
     * @return $this
     */
    public function setPublicAddress($public_address)
    {
        $this->public_address = $public_address;
        return $this;
    }

    /**
     * Get PublicAddress
     *
     * @return IPAddressInterface
     */
    public function getPublicAddress()
    {
        return $this->public_address;
    }


}
 