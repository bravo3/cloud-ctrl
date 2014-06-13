<?php
namespace Bravo3\CloudCtrl\Interfaces\Instance;

use Bravo3\CloudCtrl\Enum\Architecture;
use Bravo3\CloudCtrl\Enum\InstanceState;
use Bravo3\CloudCtrl\Interfaces\IpAddress\IpAddressInterface;
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
     * @var InstanceState
     */
    protected $instance_state;

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

    /**
     * @var string
     */
    protected $instance_size;

    /**
     * @var array
     */
    protected $tags = [];

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
     * @param InstanceState $instance_state
     * @return $this
     */
    public function setInstanceState(InstanceState $instance_state)
    {
        $this->instance_state = $instance_state;
        return $this;
    }

    /**
     * Get the instance state
     *
     * @return InstanceState
     */
    public function getInstanceState()
    {
        return $this->instance_state;
    }

    /**
     * Set Architecture
     *
     * @param Architecture $architecture
     * @return $this
     */
    public function setArchitecture(Architecture $architecture)
    {
        $this->architecture = $architecture;
        return $this;
    }

    /**
     * Get Architecture
     *
     * @return Architecture
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
     * @param IpAddressInterface $private_address
     * @return $this
     */
    public function setPrivateAddress(IpAddressInterface $private_address)
    {
        $this->private_address = $private_address;
        return $this;
    }

    /**
     * Get PrivateAddress
     *
     * @return IpAddressInterface
     */
    public function getPrivateAddress()
    {
        return $this->private_address;
    }

    /**
     * Set PublicAddress
     *
     * @param IpAddressInterface $public_address
     * @return $this
     */
    public function setPublicAddress(IpAddressInterface $public_address)
    {
        $this->public_address = $public_address;
        return $this;
    }

    /**
     * Get PublicAddress
     *
     * @return IpAddressInterface
     */
    public function getPublicAddress()
    {
        return $this->public_address;
    }

    /**
     * Set instance size
     *
     * @param string $instance_size
     * @return $this
     */
    public function setInstanceSize($instance_size)
    {
        $this->instance_size = $instance_size;
        return $this;
    }

    /**
     * Get instance size
     *
     * @return string
     */
    public function getInstanceSize()
    {
        return $this->instance_size;
    }

    /**
     * Set tags
     *
     * @param array $tags
     * @return $this
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get a specific tag
     *
     * @param string $key
     * @return string
     */
    public function getTag($key)
    {
        if (array_key_exists($key, $this->tags)) {
            return $this->tags[$key];
        } else {
            return null;
        }
    }

    /**
     * Add or replace a tag
     *
     * @param string $key
     * @param string $value
     */
    public function addTag($key, $value)
    {
        $this->tags[$key] = $value;
    }

}
 