<?php
namespace Bravo3\CloudCtrl\Interfaces\Credentials;

/**
 * Credentials for connection to a cloud provider
 */
abstract class AbstractCredential implements CredentialInterface
{
    /**
     * Equiv 'username' or 'client ID'
     * @var string
     */
    protected $identity;

    /**
     * Equiv 'password'
     * @var string
     */
    protected $secret;


    function __construct($identity = null, $secret = null)
    {
        $this->identity = $identity;
        $this->secret   = $secret;
    }


    // --


    /**
     * Set Identity
     *
     * @param $this $identity
     * @return AbstractCredential
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * Get Identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set Secret
     *
     * @param string $secret
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * Get Secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }



}
 