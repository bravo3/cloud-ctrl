<?php
namespace NovaTek\CloudCtrl\Interfaces\Common;

interface RegionAwareInterface
{
    /**
     * Set Region
     *
     * @param string $region
     * @return $this
     */
    public function setRegion($region);

    /**
     * Get Region
     *
     * @return string
     */
    public function getRegion();
} 