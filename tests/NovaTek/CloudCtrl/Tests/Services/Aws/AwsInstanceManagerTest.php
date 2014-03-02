<?php
namespace NovaTek\CloudCtrl\Tests\Services\Aws;

use Aws\Common\Enum\Region;
use NovaTek\CloudCtrl\Credentials\RegionAwareCredential;
use NovaTek\CloudCtrl\Enum\Provider;
use NovaTek\CloudCtrl\Schema\InstanceSchema;
use NovaTek\CloudCtrl\Services\Aws\AwsInstanceManager;
use NovaTek\CloudCtrl\Services\Aws\AwsService;
use NovaTek\CloudCtrl\Services\CloudService;

class AwsInstanceManagerTest extends \PHPUnit_Framework_TestCase
{
    const DRYRUN_RECEIPT = 'dry-run-only';

    /**
     * @medium
     * @group live
     */
    public function testInvalidCredentials()
    {
        $credentials =
            new RegionAwareCredential(\properties::$aws_access_key, \properties::$aws_secret.'xxx', Region::US_EAST_1);

        $service = CloudService::createCloudService(Provider::AWS, $credentials);
        $this->assertTrue($service instanceof AwsService);

        /** @var $im AwsInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof AwsInstanceManager);

        $schema = new InstanceSchema();
        $schema->setInstanceSize('t1.micro')->setTemplateImageId('ami-bba18dd2');

        $r = $im->setDryMode(true)->createInstances(1, $schema);

        $this->assertFalse($r->getSuccess());
        $this->assertEquals(403, $r->getResultCode());

    }

    /**
     * @medium
     * @group live
     */
    public function testCreateInstances()
    {
        $credentials =
            new RegionAwareCredential(\properties::$aws_access_key, \properties::$aws_secret, Region::US_EAST_1);

        $service = CloudService::createCloudService(Provider::AWS, $credentials);
        $this->assertTrue($service instanceof AwsService);

        /** @var $im AwsInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof AwsInstanceManager);

        $schema = new InstanceSchema();
        $schema->setInstanceSize('t1.micro')->setTemplateImageId('ami-bba18dd2');

        $r = $im->setDryMode(true)->createInstances(1, $schema);

        $this->assertTrue($r->getSuccess());
        $this->assertEquals(self::DRYRUN_RECEIPT, $r->getReceipt());
        $this->assertEquals(412, $r->getResultCode());


    }

}
 