<?php
namespace Bravo3\CloudCtrl\Filters\Traits;

use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;

/**
 * Filter by zone
 */
trait ZoneFilterTrait
{

    /**
     * @var ZoneInterface[]
     */
    protected $zone_list = [];

    /**
     * Set zones
     *
     * @param ZoneInterface[] $zones
     * @return $this
     */
    public function setZoneList($zones)
    {
        $this->zone_list = $zones;
        return $this;
    }

    /**
     * Get zones
     *
     * @return ZoneInterface[]
     */
    public function getZoneList()
    {
        return $this->zone_list;
    }

    /**
     * Add a zone to the list
     *
     * @param ZoneInterface $zone
     * @return $this
     */
    public function addZone(ZoneInterface $zone)
    {
        $this->zone_list[] = $zone;
        return $this;
    }

}
 