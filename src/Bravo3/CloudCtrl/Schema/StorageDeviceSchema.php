<?php
namespace Bravo3\CloudCtrl\Schema;

class StorageDeviceSchema
{
    /**
     * @var string
     */
    protected $virtual_name;

    /**
     * @var string
     */
    protected $device_name;

    /**
     * @var string
     */
    protected $snapshot_id = null;

    /**
     * @var int
     */
    protected $volume_size = 0;

    /**
     * @var bool
     */
    protected $delete_on_termination = true;

    /**
     * @var string
     */
    protected $volume_type;

    /**
     * @var bool
     */
    protected $encrypted = false;

    /**
     * @var int
     */
    protected $iops = 0;


    function __construct($device_name, $virtual_name)
    {
        $this->device_name  = $device_name;
        $this->virtual_name = $virtual_name;
    }

    /**
     * Set DeleteOnTermination
     *
     * @param boolean $delete_on_termination
     * @return $this
     */
    public function setDeleteOnTermination($delete_on_termination)
    {
        $this->delete_on_termination = $delete_on_termination;
        return $this;
    }

    /**
     * Get DeleteOnTermination
     *
     * @return boolean
     */
    public function getDeleteOnTermination()
    {
        return $this->delete_on_termination;
    }

    /**
     * Set DeviceName
     *
     * @param string $device_name
     * @return $this
     */
    public function setDeviceName($device_name)
    {
        $this->device_name = $device_name;
        return $this;
    }

    /**
     * Get DeviceName
     *
     * @return string
     */
    public function getDeviceName()
    {
        return $this->device_name;
    }

    /**
     * Set SnapshotId
     *
     * @param string $snapshot_id
     * @return $this
     */
    public function setSnapshotId($snapshot_id)
    {
        $this->snapshot_id = $snapshot_id;
        return $this;
    }

    /**
     * Get SnapshotId
     *
     * @return string
     */
    public function getSnapshotId()
    {
        return $this->snapshot_id;
    }

    /**
     * Set VirtualName
     *
     * @param string $virtual_name
     * @return $this
     */
    public function setVirtualName($virtual_name)
    {
        $this->virtual_name = $virtual_name;
        return $this;
    }

    /**
     * Get VirtualName
     *
     * @return string
     */
    public function getVirtualName()
    {
        return $this->virtual_name;
    }

    /**
     * Set the volume size in bytes
     *
     * @param int $volume_size
     * @return $this
     */
    public function setVolumeSize($volume_size)
    {
        $this->volume_size = $volume_size;
        return $this;
    }

    /**
     * Get the volume size in bytes
     *
     * @return int
     */
    public function getVolumeSize()
    {
        return $this->volume_size;
    }

    /**
     * Set VolumeType
     *
     * @param string $volume_type
     * @return $this
     */
    public function setVolumeType($volume_type)
    {
        $this->volume_type = $volume_type;
        return $this;
    }

    /**
     * Get VolumeType
     *
     * @return string
     */
    public function getVolumeType()
    {
        return $this->volume_type;
    }

    /**
     * Set the volume size in GiB/GB
     *
     * @param int  $gb
     * @param bool $binary
     */
    public function setVolumeSizeGb($gb, $binary = true)
    {
        $base = $binary ? 1024 : 1000;
        $this->setVolumeSize($gb * pow($base, 3));
    }

    /**
     * Get the volume size rounded to the nearest GiB/GB
     *
     * @param bool $binary
     * @return int
     */
    public function getVolumeSizeGb($binary = true)
    {
        $base = $binary ? 1024 : 1000;
        return round($this->getVolumeSize() / pow($base, 3));
    }

    /**
     * Set Encrypted
     *
     * @param boolean $encrypted
     * @return $this
     */
    public function setEncrypted($encrypted)
    {
        $this->encrypted = $encrypted;
        return $this;
    }

    /**
     * Get Encrypted
     *
     * @return boolean
     */
    public function getEncrypted()
    {
        return $this->encrypted;
    }

    /**
     * Set Iops
     *
     * @param int $iops
     * @return $this
     */
    public function setIops($iops)
    {
        $this->iops = $iops;
        return $this;
    }

    /**
     * Get Iops
     *
     * @return int
     */
    public function getIops()
    {
        return $this->iops;
    }



}
