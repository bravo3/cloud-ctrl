<?php
namespace Bravo3\CloudCtrl\Entity\Common;

use Bravo3\CloudCtrl\Enum\Redundancy;

/**
 * Properties for a stored object
 */
class StorageObjectProperties
{

    /**
     * @var string
     */
    protected $acl;

    /**
     * @var Redundancy
     */
    protected $redundancy;

    /**
     * @var string
     */
    protected $etag;

    /**
     * @var \DateTime
     */
    protected $last_modified;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var array<string, string>
     */
    protected $options;

    function __construct()
    {
        $this->acl        = 'private';
        $this->redundancy = Redundancy::STANDARD();
        $this->options = [];
    }

    /**
     * Set Acl
     *
     * @param string $acl
     * @return $this
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;
        return $this;
    }

    /**
     * Get Acl
     *
     * @return string
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * Set all options
     *
     * @param array <string, string> $properties
     * @return $this
     */
    public function setOptions(array $properties)
    {
        $this->options = $properties;
        return $this;
    }

    /**
     * Get all options
     *
     * @return array<string, string>
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Add an option
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * Get a option by key
     *
     * @param string      $key
     * @param string|null $default
     * @return string|null
     */
    public function getOption($key, $default = null)
    {
        return array_key_exists($key, $this->options) ? $this->options[$key] : $default;
    }

    /**
     * Set redundancy level
     *
     * @param Redundancy $redundancy
     * @return $this
     */
    public function setRedundancy($redundancy)
    {
        $this->redundancy = $redundancy;
        return $this;
    }

    /**
     * Get redundancy level
     *
     * @return Redundancy
     */
    public function getRedundancy()
    {
        return $this->redundancy;
    }

    /**
     * Set object ETag
     *
     * @param string $etag
     * @return $this
     */
    public function setEtag($etag)
    {
        $this->etag = $etag;
        return $this;
    }

    /**
     * Get object ETag
     *
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * Set the last modified date
     *
     * @param \DateTime|string $last_modified
     * @return $this
     */
    public function setLastModified($last_modified)
    {
        if (!($last_modified instanceof \DateTime)) {
            $last_modified = new \DateTime($last_modified);
        }
        $this->last_modified = $last_modified;
        return $this;
    }

    /**
     * Get the last modified date
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->last_modified;
    }

    /**
     * Set object version ID
     *
     * @param string $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Get object version ID
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }


}
 