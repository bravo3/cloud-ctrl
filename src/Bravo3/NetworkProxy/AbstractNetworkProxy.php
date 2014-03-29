<?php
namespace Bravo3\NetworkProxy;

/**
 * Abstract implementation of a proxy
 */
abstract class AbstractNetworkProxy implements NetworkProxyInterface
{
    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;


    function __construct($hostname, $port, $username = null, $password = null)
    {
        $this->hostname = $hostname;
        $this->password = $password;
        $this->port     = $port;
        $this->username = $username;
    }


    /**
     * Set the hostname
     *
     * @param string $hostname
     * @return $this
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
        return $this;
    }

    /**
     * Get the hostname
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set the password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the port
     *
     * @param int $port
     * @return $this
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * Get the port
     *
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the username
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get the username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }



}
 