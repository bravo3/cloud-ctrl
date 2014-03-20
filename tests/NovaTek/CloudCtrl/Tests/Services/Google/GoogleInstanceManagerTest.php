<?php
namespace NovaTek\CloudCtrl\Tests\Services\Google;

use NovaTek\CloudCtrl\Credentials\RegionAwareCredential;
use NovaTek\CloudCtrl\Entity\Google\GoogleCredential;
use NovaTek\CloudCtrl\Enum\Provider;
use NovaTek\CloudCtrl\Schema\InstanceSchema;
use NovaTek\CloudCtrl\Services\CloudService;
use NovaTek\CloudCtrl\Services\Google\GoogleInstanceManager;
use NovaTek\CloudCtrl\Services\Google\GoogleService;

class GoogleInstanceManagerTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @medium
     * @group live
     */
    public function testCreateInstances()
    {
        $credentials = new GoogleCredential(\properties::$aws_access_key, \properties::$aws_secret, '');

        $service = CloudService::createCloudService(Provider::GOOGLE, $credentials);
        $this->assertTrue($service instanceof GoogleService);

        /** @var $im GoogleInstanceManager */
        $im = $service->getInstanceManager();
        $this->assertTrue($im instanceof GoogleInstanceManager);

        $schema = new InstanceSchema();
        $schema->setInstanceSize('f1-micro')->setTemplateImageId('debian-7-wheezy-v20131120');

        $r = $im->setDryMode(true)->createInstances(1, $schema);
        var_dump($r);



    }

}
 