<?php
namespace NovaTek\CloudCtrl\Entity\Google;

use NovaTek\CloudCtrl\Enum\Provider;
use NovaTek\CloudCtrl\Interfaces\Instance\AbstractInstance;

class AwsInstance extends AbstractInstance
{
    /**
     * The name of the cloud provider
     *
     * @see \NovaTek\CloudCtrl\Enum\Provider
     * @return string
     */
    public function getProvider()
    {
        return Provider::GOOGLE;
    }

} 