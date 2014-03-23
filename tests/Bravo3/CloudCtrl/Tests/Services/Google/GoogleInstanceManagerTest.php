<?php
namespace Bravo3\CloudCtrl\Tests\Services\Google;

use Bravo3\CloudCtrl\Entity\Common\GenericZone;
use Bravo3\CloudCtrl\Entity\Google\GoogleCredential;
use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\CloudService;
use Bravo3\CloudCtrl\Services\Google\GoogleInstanceManager;
use Bravo3\CloudCtrl\Services\Google\GoogleService;

class GoogleInstanceManagerTest extends \PHPUnit_Framework_TestCase
{
    const APPLICATION_NAME = 'CloudCtrl Tests';


    protected function getCredentials() {
        return new GoogleCredential(\properties::$google_client_id, \properties::$google_service_account_name,
            __DIR__.'/../../Resources/privatekey.p12', \properties::$google_project_id, self::APPLICATION_NAME);
    }


    /**
     * @medium
     * @group live
     */
    public function testCreateInstances()
    {
        $credentials = $this->getCredentials();
        $service = CloudService::createCloudService(Provider::GOOGLE, $credentials);
        $this->assertTrue($service instanceof GoogleService);

        /** @var $im GoogleInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof GoogleInstanceManager);

        $schema = new InstanceSchema();
        $schema->setInstanceSize('f1-micro')->setTemplateImageId('debian-7-wheezy-v20131120')->addZone(
            new GenericZone('us-central1-a')
        );

        $r = $im->setDryMode(true)->createInstances(1, $schema);
        var_dump($r);
    }


    /**
     * @medium
     * @group live
     */
    public function testDescribeInstances()
    {
        $credentials = $this->getCredentials();
        $service = CloudService::createCloudService(Provider::GOOGLE, $credentials);
        $this->assertTrue($service instanceof GoogleService);

        /** @var $im GoogleInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof GoogleInstanceManager);

        $filter = new InstanceFilter();
        $filter->addZone(new GenericZone('us-central1-a'));

        $r = $im->setDryMode(true)->describeInstances($filter);
        $this->assertTrue($r->getSuccess());

    }

}
 