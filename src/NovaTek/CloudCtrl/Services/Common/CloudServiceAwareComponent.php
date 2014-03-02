<?php
namespace NovaTek\CloudCtrl\Services\Common;

use NovaTek\CloudCtrl\Services\CloudService;

/**
 * 
 */
class CloudServiceAwareComponent
{

    /**
     * @var CloudService
     */
    protected $cloud_service;


    function __construct(CloudService $controller)
    {
        $this->cloud_service = $controller;
    }


    /**
     * Set cloud service
     *
     * @param CloudService $controller
     * @return CloudServiceAwareComponent
     */
    public function setCloudService(CloudService $controller)
    {
        $this->cloud_service = $controller;
        return $this;
    }

    /**
     * Get cloud service
     *
     * @return CloudService
     */
    public function getCloudService()
    {
        return $this->cloud_service;
    }



}
 