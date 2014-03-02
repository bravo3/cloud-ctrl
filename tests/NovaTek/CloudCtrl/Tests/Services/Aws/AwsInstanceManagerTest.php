<?php
namespace NovaTek\CloudCtrl\Tests\Services\Aws;

use Aws\Common\Enum\Region;
use NovaTek\CloudCtrl\Credentials\RegionAwareCredential;
use NovaTek\CloudCtrl\Enum\Provider;
use NovaTek\CloudCtrl\Services\Aws\AwsInstanceManager;
use NovaTek\CloudCtrl\Services\Aws\AwsService;
use NovaTek\CloudCtrl\Services\CloudService;

class AwsInstanceManagerTest extends \PHPUnit_Framework_TestCase {

    /**
     * TODO: actually test creating and killing an instance, then break this down
     *
     * @large
     * @group live
     */
    public function testStuff()
    {
        $credentials = new RegionAwareCredential(\properties::$aws_access_key, \properties::$aws_secret, Region::US_EAST_1);

        $service = CloudService::createCloudService(Provider::AWS, $credentials);
        $this->assertTrue($service instanceof AwsService);

        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof AwsInstanceManager);


    }

}
 