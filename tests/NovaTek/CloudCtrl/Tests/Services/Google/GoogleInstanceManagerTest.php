<?php
namespace NovaTek\CloudCtrl\Tests\Services\Google;

use NovaTek\CloudCtrl\Credentials\RegionAwareCredential;
use NovaTek\CloudCtrl\Entity\Common\GenericZone;
use NovaTek\CloudCtrl\Entity\Google\GoogleCredential;
use NovaTek\CloudCtrl\Enum\Provider;
use NovaTek\CloudCtrl\Schema\InstanceSchema;
use NovaTek\CloudCtrl\Services\CloudService;
use NovaTek\CloudCtrl\Services\Google\GoogleInstanceManager;
use NovaTek\CloudCtrl\Services\Google\GoogleService;

class GoogleInstanceManagerTest extends \PHPUnit_Framework_TestCase
{
    const APPLICATION_NAME = 'CloudCtrl Tests';


    /**
     * @medium
     * @group live
     */
    public function testCreateInstances()
    {
        $credentials = new GoogleCredential(\properties::$google_client_id, \properties::$google_service_account_name,
            __DIR__.'/../../Resources/privatekey.p12', \properties::$google_project_id, self::APPLICATION_NAME);

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

}
 