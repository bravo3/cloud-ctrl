<?php
namespace Bravo3\CloudCtrl\Tests\Services\Aws;

use Aws\Common\Enum\Region;
use Bravo3\CloudCtrl\Entity\Aws\AwsCredential;
use Bravo3\CloudCtrl\Entity\Common\Zone;
use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\Aws\AwsInstanceManager;
use Bravo3\CloudCtrl\Services\Aws\AwsService;
use Bravo3\CloudCtrl\Services\CloudService;

/**
 * @group aws
 */
class AwsInstanceManagerTest extends \PHPUnit_Framework_TestCase
{
    const DRYRUN_RECEIPT = 'dry-run-only';

    public function setUp() {
        if (\properties::$aws_access_key == 'insert-key-here' || empty(\properties::$aws_access_key)) {
            $this->markTestSkipped('Skipping AWS test without a valid access key');
        }
    }

    /**
     * @medium
     * @group live
     */
    public function testInvalidCredentials()
    {
        $credentials = new AwsCredential(\properties::$aws_access_key, 'invalid-secret', Region::US_EAST_1);

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
     * @group integration
     */
    public function testCreateInstances()
    {
        $credentials = new AwsCredential(\properties::$aws_access_key, \properties::$aws_secret, Region::US_EAST_1);

        $service = CloudService::createCloudService(Provider::AWS, $credentials);
        $this->assertTrue($service instanceof AwsService);

        /** @var $im AwsInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof AwsInstanceManager);

        $schema = new InstanceSchema();
        $schema->setInstanceSize('t1.micro')->setTemplateImageId('ami-bba18dd2')->addZone(new Zone('us-east-1b'));

        $r = $im->createInstances(1, $schema);

        $this->assertTrue($r->getSuccess());
        $this->assertEquals(self::DRYRUN_RECEIPT, $r->getReceipt());
        $this->assertEquals(200, $r->getResultCode());


    }

}
 