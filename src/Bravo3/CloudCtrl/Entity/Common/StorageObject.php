<?php
namespace Bravo3\CloudCtrl\Entity\Common;

/**
 * Represents a storage object
 */
class StorageObject
{

    /**
     * @var string
     */
    protected $bucket;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $local_filename;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var StorageObjectProperties
     */
    protected $properties;

    /**
     * Create a new StorageObject from a local file
     *
     * Use StorageObject::fromData() to create an object from a variable.
     *
     * @param string                  $bucket
     * @param string                  $key
     * @param string                  $local_filename
     * @param StorageObjectProperties $properties
     */
    function __construct(
        $bucket,
        $key,
        $local_filename = null,
        StorageObjectProperties $properties = null
    ) {
        $this->data           = null;
        $this->bucket         = $bucket;
        $this->key            = $key;
        $this->local_filename = $local_filename;
        $this->properties     = $properties ? : new StorageObjectProperties();
    }

    /**
     * Create a new StorageObject from data in memory instead of a local file
     *
     * @param string                  $bucket
     * @param string                  $key
     * @param string                  $data
     * @param StorageObjectProperties $properties
     * @return StorageObject
     */
    public static function fromData($bucket, $key, $data, StorageObjectProperties $properties = null)
    {
        $object = new self($bucket, $key, null, $properties);
        $object->setData($data);
        return $object;
    }

    /**
     * Set bucket name
     *
     * @param string $bucket
     * @return $this
     */
    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
        return $this;
    }

    /**
     * Get bucket name
     *
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * Set object data
     *
     * This data will be used to upload to storage facilities. If the data is null but a local filename is present, the
     * local file data will be uploaded instead.
     *
     * @param string $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get object data
     *
     * If this object was stored to a local file, data will be pulled directly from the file. If it was not stored to
     * a local file, it will be cached in memory.
     *
     * @return string
     */
    public function getData()
    {
        if ($this->data === null && $this->local_filename) {
            return file_get_contents($this->local_filename);
        }

        return $this->data;
    }

    /**
     * Return true if we have data in memory
     *
     * @return bool
     */
    public function hasCachedData()
    {
        return !is_null($this->data);
    }

    /**
     * Set storage key
     *
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Get storage key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the local filename of this object
     *
     * @param string $local_filename
     * @return $this
     */
    public function setLocalFilename($local_filename)
    {
        $this->local_filename = $local_filename;
        return $this;
    }

    /**
     * Get the local filename of this object
     *
     * @return string
     */
    public function getLocalFilename()
    {
        return $this->local_filename;
    }

    /**
     * Set the object properties
     *
     * @param StorageObjectProperties $properties
     * @return $this
     */
    public function setProperties(StorageObjectProperties $properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * Get the object properties
     *
     * @return StorageObjectProperties
     */
    public function getProperties()
    {
        return $this->properties;
    }


}
 