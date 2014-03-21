<?php
namespace NovaTek\CloudCtrl\Interfaces\Credentials;

use NovaTek\CloudCtrl\Interfaces\Common\RegionAwareTrait;

/**
 * Credentials for connection to a cloud provider
 */
class AbstractRegionAwareCredential extends AbstractCredential implements RegionAwareCredentialInterface
{
    use RegionAwareTrait;

    function __construct($identity = null, $secret = null, $region = null)
    {
        parent::__construct($identity, $secret);
        $this->region = $region;
    }


}
 