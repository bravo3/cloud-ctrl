<?php
namespace NovaTek\CloudCtrl\Interfaces\Common;

trait RegionAwareTrait
{

    protected $region;

    /**
     * Set Region
     *
     * @param mixed $region
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get Region
     *
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }


} 