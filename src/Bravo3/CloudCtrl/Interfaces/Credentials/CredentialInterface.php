<?php
namespace Bravo3\CloudCtrl\Interfaces\Credentials;

interface CredentialInterface
{
    /**
     * Set Identity
     *
     * @param $this $identity
     * @return AbstractCredential
     */
    public function setIdentity($identity);

    /**
     * Get Identity
     *
     * @return string
     */
    public function getIdentity();

    /**
     * Set Secret
     *
     * @param string $secret
     * @return $this
     */
    public function setSecret($secret);

    /**
     * Get Secret
     *
     * @return string
     */
    public function getSecret();

} 