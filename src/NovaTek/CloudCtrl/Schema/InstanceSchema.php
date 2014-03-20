<?php
namespace NovaTek\CloudCtrl\Schema;

use NovaTek\CloudCtrl\Entities\Zone\ZoneInterface;
use NovaTek\CloudCtrl\Enum\Tenancy;
use NovaTek\CloudCtrl\Exceptions\InvalidValueException;

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
     * TODO: de-AWS the terminology
     *
     * @var string
     */
    protected $security_groups = [];

    /**
     * @var string
     */
    protected $tenancy = Tenancy::VPC;

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
     * Set security group ID list
     *
     * @param string $security_groups[]
     * @return $this
     */
    public function setSecurityGroups($security_groups)
    {
        $this->security_groups = $security_groups;
        return $this;
    }

    /**
     * Get all security group IDs
     *
     * @return string[]
     */
    public function getSecurityGroups()
    {
        return $this->security_groups;
    }

    /**
     * Add a security group
     *
     * @param $id
     * @return $this
     */
    public function addSecurityGroup($id)
    {
        $this->security_groups[] = $id;
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
     * @param Zone[] $zones
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
        if (!in_array($tenancy, Tenancy::getValidTenancyTypes())) {
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



}
 