<?php
namespace Bravo3\CloudCtrl\Interfaces\Common;

use Bravo3\CloudCtrl\Enum\Architecture;
use Bravo3\CloudCtrl\Enum\ImageState;

class AbstractImage implements ImageInterface
{

    /**
     * @var string
     */
    protected $image_id;

    /**
     * @var string
     */
    protected $image_location;

    /**
     * @var ImageState
     */
    protected $state;

    /**
     * @var string
     */
    protected $owner;

    /**
     * @var bool
     */
    protected $is_public;

    /**
     * @var Architecture
     */
    protected $architecture;

    /**
     * TODO: make this a type
     *
     * @var string
     */
    protected $image_type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $tags = [];

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
     * Set Description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ImageId
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
     * Get ImageId
     *
     * @return string
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * Set ImageLocation
     *
     * @param string $image_location
     * @return $this
     */
    public function setImageLocation($image_location)
    {
        $this->image_location = $image_location;
        return $this;
    }

    /**
     * Get ImageLocation
     *
     * @return string
     */
    public function getImageLocation()
    {
        return $this->image_location;
    }

    /**
     * Set image type
     *
     * @param string $image_type
     * @return $this
     */
    public function setImageType($image_type)
    {
        $this->image_type = $image_type;
        return $this;
    }

    /**
     * Get image type
     *
     * @return string
     */
    public function getImageType()
    {
        return $this->image_type;
    }

    /**
     * Set IsPublic
     *
     * @param boolean $is_public
     * @return $this
     */
    public function setPublic($is_public)
    {
        $this->is_public = (bool)$is_public;
        return $this;
    }

    /**
     * Get IsPublic
     *
     * @return boolean
     */
    public function isPublic()
    {
        return $this->is_public;
    }

    /**
     * Set image name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get image name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set owner
     *
     * @param string $owner
     * @return $this
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set State
     *
     * @param ImageState $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get State
     *
     * @return ImageState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set Tags
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
     * Get Tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
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

    /**
     * Remove a tag
     *
     * @param string $key
     */
    public function removeTag($key)
    {
        if (array_key_exists($key, $this->tags)) {
            unset($this->tags[$key]);
        }
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


}
