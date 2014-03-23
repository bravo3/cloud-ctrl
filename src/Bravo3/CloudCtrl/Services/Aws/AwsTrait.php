<?php
namespace Bravo3\CloudCtrl\Services\Aws;

use Aws\Common\Aws;

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
        /** @var $cloud_service \Bravo3\CloudCtrl\Services\CloudService */
        $cloud_service = $this->getCloudService();

        $config    = [
            'key'    => $cloud_service->getCredentials()->getIdentity(),
            'secret' => $cloud_service->getCredentials()->getSecret(),
            'region' => $cloud_service->getRegion()
        ];
        $this->aws = Aws::factory($config);
    }


    /**
     * Get cloud service
     * Should be implemented by
     *
     * @see \Bravo3\CloudCtrl\Services\CloudService
     * @return $this
     */
    abstract public function getCloudService();

} 