<?php
namespace Bravo3\CloudCtrl\Tests\Services;

use Bravo3\CloudCtrl\Credentials\RegionAwareCredential;
use Bravo3\CloudCtrl\Entity\Aws\AwsCredential;
use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Services\Aws\AwsService;
use Bravo3\CloudCtrl\Services\CloudService;
use Bravo3\CloudCtrl\Services\Common\InstanceManager;

class CloudServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @small
     */
    public function testServiceFactory()
    {
        $service = CloudService::createCloudService(Provider::AWS, new AwsCredential());
        $this->assertTrue($service instanceof AwsService);
        $this->assertTrue($service->getInstanceManager() instanceof InstanceManager);
    }

}
 