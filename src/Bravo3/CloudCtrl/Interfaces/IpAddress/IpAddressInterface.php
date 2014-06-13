<?php
namespace Bravo3\CloudCtrl\Interfaces\IpAddress;

interface IpAddressInterface
{

    /**
     * Check if we have an IPv4 address available
     *
     * @return bool
     */
    public function hasIp4Address();

    /**
     * Check if we have an IPv6 address available
     *
     * @return bool
     */
    public function hasIp6Address();

    /**
     * Get the IPv4 address
     *
     * @return string
     */
    public function getIp4Address();

    /**
     * Get the IPv6 address
     *
     * @return string
     */
    public function getIp6Address();

    /**
     * Get the DNS name if one exists
     *
     * @return string|null
     */
    public function getDnsName();

}
 