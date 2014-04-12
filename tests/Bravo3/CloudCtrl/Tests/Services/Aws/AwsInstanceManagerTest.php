<?php
namespace Bravo3\CloudCtrl\Tests\Services\Aws;

use Bravo3\CloudCtrl\Entity\Common\Zone;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\Aws\AwsInstanceManager;
use Bravo3\CloudCtrl\Tests\Base\AwsTestBase;

/**
 * @group aws
 */
class AwsInstanceManagerTest extends AwsTestBase
{
    const DRYRUN_RECEIPT = 'dry-run-only';

    /**
     * @medium
     * @group live
     */
    public function testInvalidAwsSecret()
    {
        $credentials = $this->properties->getAwsCredentials();
        $credentials->setSecret('xxx');
        $service = $this->getService($credentials);

        /** @var $im AwsInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof AwsInstanceManager);

        $schema = new InstanceSchema();
        $schema->setInstanceSize('t1.micro')->setTemplateImageId('ami-bba18dd2');

        $r = $im->createInstances(1, $schema);

        $this->assertFalse($r->getSuccess());
        $this->assertEquals(403, $r->getResultCode());
    }

    /**
     * @medium
     * @group live
     */
    public function testInvalidAwsKey()
    {
        $credentials = $this->properties->getAwsCredentials();
        $credentials->setIdentity('xxx');
        $service = $this->getService($credentials);

        /** @var $im AwsInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof AwsInstanceManager);

        $schema = new InstanceSchema();
        $schema->setInstanceSize('t1.micro')->setTemplateImageId('ami-bba18dd2');

        $r = $im->createInstances(1, $schema);

        $this->assertFalse($r->getSuccess());
        $this->assertEquals(401, $r->getResultCode());
    }

    /**
     * @medium
     * @group live
     * @group integration
     */
    public function testCreateAwsInstances()
    {
        $service = $this->getService();

        /** @var $im AwsInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof AwsInstanceManager);

        $schema = new InstanceSchema();
        $schema->setInstanceSize('t1.micro')->setTemplateImageId('ami-bba18dd2')->addZone(new Zone('us-east-1b'));

        $r = $im->createInstances(1, $schema);

        $this->assertTrue($r->getSuccess());
        $this->assertEquals(1, $r->getInstances()->count());

    }

}
 