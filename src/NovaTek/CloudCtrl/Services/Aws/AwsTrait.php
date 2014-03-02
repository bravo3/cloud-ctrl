<?php
namespace NovaTek\CloudCtrl\Services\Aws;

use Aws\Common\Aws;
use NovaTek\CloudCtrl\Services\CloudService;

/**
 * Amazon-specific common service functionality
 */
trait AwsTrait
{
    /**
     * @var Aws
     */
    protected $aws;

    /**
     * Reset the AWS service, for a new account/region
     */
    protected function resetServices()
    {
        $this->aws = null;
    }

    /**
     * Get an AWS service
     *
     * @param string $service
     * @return mixed
     */
    protected function getService($service)
    {
        if ($this->aws === null) {
            $this->createAwsService();
        }

        return $this->aws->get($service);
    }

    /**
     * Recreate the AWS service
     */
    protected function createAwsService()
    {
        $config    = [
            'key'    => $this->getCloudService()->getCredentials()->getIdentity(),
            'secret' => $this->getCloudService()->getCredentials()->getSecret(),
            'region' => $this->getCloudService()->getRegion()
        ];
        $this->aws = Aws::factory($config);
    }


    /**
     * Get cloud service
     * Should be implemented by CloudServiceAwareComponent
     *
     * @return $this
     */
    abstract public function getCloudService();

} 