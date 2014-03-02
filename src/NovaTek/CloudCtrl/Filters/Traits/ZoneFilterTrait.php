<?php
namespace NovaTek\CloudCtrl\Filters\Traits;

/**
 * Filter by zone
 */
trait ZoneFilterTrait
{

    /**
     * @var string[]
     */
    protected $zoneList = [];

    /**
     * Set zones
     *
     * @param \string[] $zones
     * @return $this
     */
    public function setZoneList($zones)
    {
        $this->zoneList = $zones;
        return $this;
    }

    /**
     * Get zones
     *
     * @return \string[]
     */
    public function getZoneList()
    {
        return $this->zoneList;
    }

    /**
     * Add a zone to the list
     *
     * @param $zone
     * @return $this
     */
    public function addZone($zone)
    {
        $this->zoneList[] = $zone;
        return $this;
    }

}
 