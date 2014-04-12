<?php
namespace Bravo3\CloudCtrl\Tests\Services\Google;

use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Entity\Common\Zone;
use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\Google\GoogleInstanceManager;
use Bravo3\CloudCtrl\Tests\Base\GoogleTestBase;

/**
 * @group google
 */
class GoogleInstanceManagerTest extends GoogleTestBase
{
    const APPLICATION_NAME = 'CloudCtrl Tests';
    const SOURCE_DISK = "https://www.googleapis.com/compute/v1/projects/debian-cloud/global/images/debian-7-wheezy-v20140408";

    /**
     * @medium
     * @group live
     * @group integration
     */
    public function testCreateGoogleInstances()
    {
        $service = $this->getService();

        /** @var $im GoogleInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof GoogleInstanceManager);

        $schema = new InstanceSchema();
        $schema->setInstanceSize('f1-micro')->setTemplateImageId(self::SOURCE_DISK)->addZone(
            new Zone('us-central1-a')
        );

        $r = $im->createInstances(1, $schema);
        $this->assertEquals(1, $r->getInstances()->count());
    }

    /**
     * @medium
     * @group live
     */
    public function testDescribeGoogleInstances()
    {
        $service = $this->getService();

        /** @var $im GoogleInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof GoogleInstanceManager);

        $filter = new InstanceFilter();
        $filter->addZone(new Zone('us-central1-a'));

        $r = $im->setDryMode(true)->describeInstances($filter);
        $this->assertTrue($r->getSuccess());
        $this->assertTrue($r->getInstances() instanceof InstanceCollection);
    }

}
 