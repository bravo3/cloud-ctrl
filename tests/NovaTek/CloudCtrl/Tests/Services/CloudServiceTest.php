<?php
namespace NovaTek\CloudCtrl\Tests\Services;

use NovaTek\CloudCtrl\Credentials\RegionAwareCredential;
use NovaTek\CloudCtrl\Enum\Provider;
use NovaTek\CloudCtrl\Services\Aws\AwsService;
use NovaTek\CloudCtrl\Services\CloudService;
use NovaTek\CloudCtrl\Services\Common\InstanceManager;

class CloudServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @small
     */
    public function testServiceFactory()
    {
        $service = CloudService::createCloudService(Provider::AWS, new RegionAwareCredential());
        $this->assertTrue($service instanceof AwsService);
        $this->assertTrue($service->getInstanceManager() instanceof InstanceManager);
    }

}
 