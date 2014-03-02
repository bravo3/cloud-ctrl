<?php
namespace NovaTek\CloudCtrl\Schema;

use NovaTek\CloudCtrl\Entity\Zone;

/**
 * Instance definition for constructing instances
 *
 * $baseImage, $zones, $size, $tags, $keyPairs, $securityGroup
 */
class InstanceSchema
{

    /**
     * Template image ID
     *
     * @var string
     */
    protected $template_image_id;

    /**
     * List of zones to launch the instances evenly across
     *
     * @var Zone[]
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
     * @var string[]
     */
    protected $key_pairs = [];

    /**
     * TODO: de-AWS the terminology
     *
     * @var string
     */
    protected $security_group;

    // --

    /**
     * Set InstanceSize
     *
     * @param string $instance_size
     * @return InstanceSchema
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
     * Set KeyPairs
     *
     * @param string[] $key_pairs
     * @return InstanceSchema
     */
    public function setKeyPairs($key_pairs)
    {
        $this->key_pairs = $key_pairs;
        return $this;
    }

    /**
     * Get KeyPairs
     *
     * @return array
     */
    public function getKeyPairs()
    {
        return $this->key_pairs;
    }


    /**
     * Add a key-pair
     *
     * @param string $key_pair
     * @return InstanceSchema
     */
    public function addKeyPair($key_pair)
    {
        $this->key_pairs[] = $key_pair;
        return $this;
    }

    /**
     * Set SecurityGroup
     *
     * @param string $security_group
     * @return InstanceSchema
     */
    public function setSecurityGroup($security_group)
    {
        $this->security_group = $security_group;
        return $this;
    }

    /**
     * Get SecurityGroup
     *
     * @return string
     */
    public function getSecurityGroup()
    {
        return $this->security_group;
    }

    /**
     * Set Tags
     *
     * @param array $tags
     * @return InstanceSchema
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
     * @return InstanceSchema
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
     * @return InstanceSchema
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
     * @return InstanceSchema
     */
    public function setZones($zones)
    {
        $this->zones = $zones;
        return $this;
    }

    /**
     * Get Zones
     *
     * @return Zone[]
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * Add a zone
     *
     * @param Zone $zone
     * @return InstanceSchema
     */
    public function addZone(Zone $zone)
    {
        $this->zones[] = $zone;
        return $this;
    }

}
 