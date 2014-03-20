<?php
namespace NovaTek\CloudCtrl\Entity\Azure;

use NovaTek\CloudCtrl\Enum\Provider;

class AzureInstance
{
    /**
     * The name of the cloud provider
     *
     * @see \NovaTek\CloudCtrl\Enum\Provider
     * @return string
     */
    public function getProvider()
    {
        return Provider::AZURE;
    }
} 