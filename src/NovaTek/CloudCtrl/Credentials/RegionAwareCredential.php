<?php
namespace NovaTek\CloudCtrl\Credentials;

/**
 * Credentials for connection to a cloud provider
 */
class RegionAwareCredential extends Credential
{
    /**
     * @var string
     */
    protected $region;

    function __construct($identity = null, $secret = null, $region = null)
    {
        parent::__construct($identity, $secret);
        $this->region = $region;
    }


    // --

    /**
     * Set Region
     *
     * @param string $region
     * @return RegionAwareCredential
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get Region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }


}
 