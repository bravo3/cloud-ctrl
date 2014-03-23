<?php
namespace Bravo3\CloudCtrl\Entity\Aws;

use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Interfaces\Instance\AbstractInstance;

class AwsInstance extends AbstractInstance
{
    /**
     * The name of the cloud provider
     *
     * @see \Bravo3\CloudCtrl\Enum\Provider
     * @return string
     */
    public function getProvider()
    {
        return Provider::AWS;
    }

} 