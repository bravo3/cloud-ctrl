<?php
namespace Bravo3\CloudCtrl\Schema;

class ImageSchema
{
    /**
     * @var string
     */
    protected $image_name;

    /**
     * @var string
     */
    protected $image_description = '';

    /**
     * @var bool
     */
    protected $allow_reboot = true;

    /**
     * @var StorageDeviceSchema[]
     */
    protected $storage_devices = [];


    function __construct($image_name = '')
    {
        $this->image_name = $image_name;
    }

    /**
     * Set AllowReboot
     *
     * @param boolean $allow_reboot
     * @return $this
     */
    public function setAllowReboot($allow_reboot)
    {
        $this->allow_reboot = $allow_reboot;
        return $this;
    }

    /**
     * Get AllowReboot
     *
     * @return boolean
     */
    public function getAllowReboot()
    {
        return $this->allow_reboot;
    }

    /**
     * Set ImageDescription
     *
     * @param string $image_description
     * @return $this
     */
    public function setImageDescription($image_description)
    {
        $this->image_description = $image_description;
        return $this;
    }

    /**
     * Get ImageDescription
     *
     * @return string
     */
    public function getImageDescription()
    {
        return $this->image_description;
    }

    /**
     * Set ImageName
     *
     * @param string $image_name
     * @return $this
     */
    public function setImageName($image_name)
    {
        $this->image_name = $image_name;
        return $this;
    }

    /**
     * Get ImageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->image_name;
    }

    /**
     * Set StorageDevices
     *
     * @param StorageDeviceSchema[] $storage_devices
     * @return $this
     */
    public function setStorageDevices(array $storage_devices)
    {
        $this->storage_devices = $storage_devices;
        return $this;
    }

    /**
     * Get StorageDevices
     *
     * @return StorageDeviceSchema[]
     */
    public function getStorageDevices()
    {
        return $this->storage_devices;
    }

    /**
     * Add a storage volume
     *
     * @param StorageDeviceSchema $volume
     * @return $this
     */
    public function addStorageDevice(StorageDeviceSchema $volume)
    {
        $this->storage_devices[] = $volume;
        return $this;
    }

} 