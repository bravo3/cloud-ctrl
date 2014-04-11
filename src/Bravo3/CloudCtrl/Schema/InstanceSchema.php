<?php
namespace Bravo3\CloudCtrl\Schema;

use Bravo3\CloudCtrl\Enum\Tenancy;
use Bravo3\CloudCtrl\Exceptions\InvalidValueException;
use Bravo3\CloudCtrl\Interfaces\Instance\InstanceNameGeneratorInterface;
use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;

/**
 * Instance definition for constructing instances
 *
 * TODO: consider UserData - this might not be consistent, but is probably important
 *       get through all major providers before considering this
 */
class InstanceSchema
{

    /**
     * Template image ID
     *
     * @var string
     */
    protected $template_image_id = null;

    /**
     * List of zones to launch the instances evenly across
     *
     * @var ZoneInterface[]
     */
    protected $zones = [];

    /**
     * Name of the instance size
     *
     * @var string
     */
    protected $instance_size;

    /**
     * Key/value array of tags to apply to all instances
     *
     * @var array
     */
    protected $tags = [];

    /**
     * TODO: de-AWS the terminology
     *
     * @var string
     */
    protected $key_name = null;

    /**
     * Firewall/security groups
     *
     * @var string[]
     */
    protected $firewalls = [];

    /**
     * VPC/Network
     *
     * @var string
     */
    protected $network = null;

    /**
     * @var string
     */
    protected $tenancy = Tenancy::VPC;

    /**
     * @var InstanceNameGeneratorInterface
     */
    protected $name_generator = null;

    // --

    /**
     * Set InstanceSize
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
     * Get InstanceSize
     *
     * @return string
     */
    public function getInstanceSize()
    {
        return $this->instance_size;
    }

    /**
     * Set key-pair name
     *
     * @param string $key_name
     * @return $this
     */
    public function setKeyName($key_name)
    {
        $this->key_name = $key_name;
        return $this;
    }

    /**
     * Get key-pair name
     *
     * @return string
     */
    public function getKeyName()
    {
        return $this->key_name;
    }

    /**
     * Set firewall/security group list
     *
     * @param string $firewalls[]
     * @return $this
     */
    public function setFirewalls($firewalls)
    {
        $this->firewalls = $firewalls;
        return $this;
    }

    /**
     * Get all firewall/security groups
     *
     * @return string[]
     */
    public function getFirewalls()
    {
        return $this->firewalls;
    }

    /**
     * Add a firewall/security group
     *
     * @param $id
     * @return $this
     */
    public function addFirewall($id)
    {
        $this->firewalls[] = $id;
        return $this;
    }

    /**
     * Set Tags
     *
     * @param array $tags
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Get Tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add a tag
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function addTag($key, $value)
    {
        $this->tags[$key] = $value;
        return $this;
    }

    /**
     * Set the base image ID that is to be used as the template
     *
     * @param string $template_image_id
     * @return $this
     */
    public function setTemplateImageId($template_image_id)
    {
        $this->template_image_id = $template_image_id;
        return $this;
    }

    /**
     * Get the base image ID that is to be used as the template
     *
     * @return string
     */
    public function getTemplateImageId()
    {
        return $this->template_image_id;
    }

    /**
     * Set Zones
     *
     * @param ZoneInterface[] $zones
     * @return $this
     */
    public function setZones($zones)
    {
        $this->zones = $zones;
        return $this;
    }

    /**
     * Get Zones
     *
     * @return ZoneInterface[]
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * Add a zone
     *
     * @param ZoneInterface $zone
     * @return $this
     */
    public function addZone(ZoneInterface $zone)
    {
        $this->zones[] = $zone;
        return $this;
    }

    /**
     * Set Tenancy
     *
     * @param string $tenancy
     * @return $this
     * @throws InvalidValueException
     */
    public function setTenancy($tenancy)
    {
        if (!in_array($tenancy, Tenancy::members())) {
            throw new InvalidValueException();
        }

        $this->tenancy = $tenancy;
        return $this;
    }

    /**
     * Get Tenancy
     *
     * @return string
     */
    public function getTenancy()
    {
        return $this->tenancy;
    }

    /**
     * Set the instance name generator
     *
     * @param InstanceNameGeneratorInterface $name_generator
     * @return $this
     */
    public function setNameGenerator($name_generator)
    {
        $this->name_generator = $name_generator;
        return $this;
    }

    /**
     * Get the instance name generator
     *
     * @return InstanceNameGeneratorInterface
     */
    public function getNameGenerator()
    {
        return $this->name_generator;
    }

    /**
     * Set the VPC/network
     *
     * @param string $network
     * @return $this
     */
    public function setNetwork($network)
    {
        $this->network = $network;
        return $this;
    }

    /**
     * Get the VPC/network
     *
     * @return string
     */
    public function getNetwork()
    {
        return $this->network;
    }



}
 