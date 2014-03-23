<?php
namespace Bravo3\CloudCtrl\Entity\Azure;

use Bravo3\CloudCtrl\Enum\Provider;

class AzureInstance
{
    /**
     * The name of the cloud provider
     *
     * @see \Bravo3\CloudCtrl\Enum\Provider
     * @return string
     */
    public function getProvider()
    {
        return Provider::AZURE;
    }
} 