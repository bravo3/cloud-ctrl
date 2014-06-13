<?php
namespace Bravo3\CloudCtrl\Interfaces\IpAddress;

abstract class AbstractIpAddress implements IpAddressInterface
{
    /**
     * @var string
     */
    protected $ip4address = null;

    /**
     * @var string
     */
    protected $ip6address = null;

    /**
     * @var string
     */
    protected $dns_name = null;

    /**
     * Construct an new IP address
     *
     * @param string $ip4address
     * @param string $ip6address
     * @param string $dns_name
     */
    function __construct($ip4address, $ip6address = null, $dns_name = null)
    {
        $this->ip4address = $ip4address;
        $this->ip6address = $ip6address;
        $this->dns_name   = $dns_name;
    }


    /**
     * Get DnsName
     *
     * @return string
     */
    public function getDnsName()
    {
        return $this->dns_name;
    }

    /**
     * Get Ip4address
     *
     * @return string
     */
    public function getIp4Address()
    {
        return $this->ip4address;
    }


    /**
     * Get Ip6address
     *
     * @return string
     */
    public function getIp6Address()
    {
        return $this->ip6address;
    }

    /**
     * Check if we have an IPv4 address available
     *
     * @return bool
     */
    public function hasIp4Address()
    {
        return $this->ip4address !== null;
    }

    /**
     * Check if we have an IPv6 address available
     *
     * @return bool
     */
    public function hasIp6Address()
    {
        return $this->ip6address !== null;
    }


} 