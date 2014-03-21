<?php
namespace NovaTek\CloudCtrl\Interfaces\Zone;

class AbstractZone implements ZoneInterface
{

    /**
     * @var string
     */
    protected $zone_name;

    /**
     * Create a new zone
     *
     * @param string $zone_name
     */
    function __construct($zone_name)
    {
        $this->zone_name = $zone_name;
    }


    /**
     * Get ZoneName
     *
     * @return string
     */
    public function getZoneName()
    {
        return $this->zone_name;
    }



} 