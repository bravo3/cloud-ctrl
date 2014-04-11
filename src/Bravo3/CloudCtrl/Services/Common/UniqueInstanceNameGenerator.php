<?php
namespace Bravo3\CloudCtrl\Services\Common;

use Bravo3\CloudCtrl\Interfaces\Instance\InstanceNameGeneratorInterface;
use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;
use Bravo3\CloudCtrl\Schema\InstanceSchema;

/**
 * Generates an instance name from a unique ID
 * Has the option to include a prefix, suffix, zone name or sequence number
 */
class UniqueInstanceNameGenerator implements InstanceNameGeneratorInterface
{

    protected $prefix = 'i-';
    protected $suffix = '';
    protected $include_zone = false;
    protected $include_sequence = false;

    /**
     * Generate a new instance name
     *
     * @param InstanceSchema $schema   Schema used to create this instance
     * @param ZoneInterface  $zone     The selected zone
     * @param integer        $sequence Zero-indexed instance number of the create wad
     * @return string
     */
    public function getInstanceName(InstanceSchema $schema, ZoneInterface $zone, $sequence)
    {
        $name = str_replace('.', '', $this->prefix.uniqid('', true));

        if ($this->include_zone && !is_null($zone)) {
            $name .= '-'.$zone->getZoneName();
        }

        if ($this->include_sequence) {
            $name .= '-'.$sequence;
        }

        return $name.$this->suffix;
    }

    /**
     * Set the option to include the sequence number
     *
     * @param boolean $include_sequence
     * @return $this
     */
    public function setIncludeSequence($include_sequence)
    {
        $this->include_sequence = $include_sequence;
        return $this;
    }

    /**
     * Get the option to include the sequence number
     *
     * @return boolean
     */
    public function getIncludeSequence()
    {
        return $this->include_sequence;
    }

    /**
     * Set the option to include the zone name
     *
     * @param boolean $include_zone
     * @return $this
     */
    public function setIncludeZone($include_zone)
    {
        $this->include_zone = $include_zone;
        return $this;
    }

    /**
     * Get the option to include the zone name
     *
     * @return boolean
     */
    public function getIncludeZone()
    {
        return $this->include_zone;
    }

    /**
     * Set Prefix
     *
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * Get Prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set Suffix
     *
     * @param string $suffix
     * @return $this
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * Get Suffix
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }


}
 