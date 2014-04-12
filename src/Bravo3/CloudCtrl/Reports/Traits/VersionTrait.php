<?php
namespace Bravo3\CloudCtrl\Reports\Traits;

/**
 * Object has a version
 */
trait VersionTrait
{
    protected $version;

    /**
     * Set Version
     *
     * @param mixed $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Get Version
     *
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

}
 