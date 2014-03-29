<?php
namespace Bravo3\NetworkProxy;

/**
 * Define a SOCKS/HTTP proxy
 */
interface NetworkProxyInterface
{

    /**
     * Get the proxy hostname/ip address
     *
     * @return string
     */
    public function getHostname();

    /**
     * Get the proxy port
     *
     * @return int
     */
    public function getPort();

    /**
     * Get the username for the proxy connection
     *
     * @return string|null
     */
    public function getUsername();

    /**
     * Get the password for the proxy connection, this is ignored if the username is null
     *
     * @return string|null
     */
    public function getPassword();

}
 