<?php
namespace Bravo3\CloudCtrl\Tests\Services\Aws;

use Bravo3\CloudCtrl\Collections\ImageCollection;
use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Entity\Common\Zone;
use Bravo3\CloudCtrl\Enum\ImageState;
use Bravo3\CloudCtrl\Enum\InstanceState;
use Bravo3\CloudCtrl\Filters\IdFilter;
use Bravo3\CloudCtrl\Filters\ImageFilter;
use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Schema\ImageSchema;
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
        $schema->setInstanceSize('t1.micro')->setTemplateImageId('ami-3b4bd301');

        $r = $im->createInstances(1, $schema);

        $this->assertFalse($r->getSuccess());
        $this->assertEquals(401, $r->getResultCode());
    }

    /**
     * @large
     * @group live
     * @group integration
     *
     * This test runs through the process of creating an instance, monitoring it, shutting it down, saving an image
     * and then terminating all resources.
     */
    public function testAwsIntegration()
    {
        $service = $this->getService();

        /** @var $im AwsInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof AwsInstanceManager);

        // -- CREATE INSTANCE -- //
        $this->log("Creating instance");
        $schema = new InstanceSchema();
        $schema->setInstanceSize('t1.micro')->setTemplateImageId('ami-3b4bd301')->addZone(new Zone('ap-southeast-2a'));

        $r = $im->createInstances(1, $schema);

        $this->assertTrue($r->getSuccess());
        $this->assertEquals(1, $r->getInstances()->count());

        $instance_id = $r->getInstances()->toArray()[0]->getInstanceId();

        $instance_filter = new InstanceFilter();
        $instance_filter->addId($instance_id);

        $instance_id_filter = new IdFilter();
        $instance_id_filter->addId($instance_id);

        // Wait until it's ready
        $this->log("Wait for ready: ".$instance_id);
        do {
            sleep(5);
            $r = $im->describeInstances($instance_filter);
            $this->assertTrue($r->getSuccess());
            $this->assertTrue($r->getInstances() instanceof InstanceCollection);
        } while ($r->getInstances()->toArray()[0]->getInstanceState() != InstanceState::RUNNING());

        // Stop the instance
        $this->log("Stopping instance");
        $r = $im->stopInstances($instance_id_filter);
        $this->assertTrue($r->getSuccess());

        // Wait until it's stopped
        $this->log("Wait for stop");
        do {
            sleep(5);
            $r = $im->describeInstances($instance_filter);
            $this->assertTrue($r->getSuccess());
            $this->assertTrue($r->getInstances() instanceof InstanceCollection);
            $this->assertFalse($r->getInstances()->toArray()[0]->getInstanceState() == InstanceState::TERMINATED());
        } while ($r->getInstances()->toArray()[0]->getInstanceState() != InstanceState::STOPPED());

        // -- SAVE AN AMI -- //
        $this->log("Saving AMI");
        $r = $im->createImage($instance_id, new ImageSchema('test-ami'));
        $this->assertTrue($r->getSuccess());

        $image_id = $r->getImageId();
        $image_filter = new ImageFilter();
        $image_filter->addId($image_id);

        // Wait until it's ready
        $this->log("Wait for available: ".$image_id);
        do {
            sleep(5);
            $r = $im->describeImages($image_filter);
            $this->assertTrue($r->getSuccess());
            $this->assertTrue($r->getImages() instanceof ImageCollection);
        } while ($r->getImages()->toArray()[0]->getState() != ImageState::AVAILABLE());

        // -- TERMINATE ALL -- //
        $this->log("Terminating instance");
        $r = $im->terminateInstances($instance_id_filter);
        $this->assertTrue($r->getSuccess());

        $this->log("Deregistering image");
        $r = $im->deregisterImage($image_id);
        $this->assertTrue($r->getSuccess());

    }

    protected function log($txt) {
        echo $txt."\n";
        ob_flush(); flush();
    }

}
 