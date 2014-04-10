<?php
namespace Bravo3\CloudCtrl\Tests\Services\Google;

use Bravo3\CloudCtrl\Entity\Common\Zone;
use Bravo3\CloudCtrl\Entity\Google\GoogleCredential;
use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\CloudService;
use Bravo3\CloudCtrl\Services\Google\GoogleInstanceManager;
use Bravo3\CloudCtrl\Services\Google\GoogleService;

/**
 * @group google
 */
class GoogleInstanceManagerTest extends \PHPUnit_Framework_TestCase
{
    const APPLICATION_NAME = 'CloudCtrl Tests';

    protected function getPrivateKey()
    {
        return __DIR__.'/../../Resources/google-privatekey.p12';
    }

    /**
     * Get the credentials
     *
     * @return GoogleCredential
     */
    protected function getCredentials()
    {
        return new GoogleCredential(\properties::$google_client_id, \properties::$google_service_account_name,
            $this->getPrivateKey(), \properties::$google_project_id, self::APPLICATION_NAME);
    }

    /**
     * Get the GoogleService
     *
     * @return GoogleService
     */
    protected function getService() {
        $service     = CloudService::createCloudService(Provider::GOOGLE, $this->getCredentials());
        $this->assertTrue($service instanceof GoogleService);
        $service->setProxy(\properties::getProxy());

        return $service;
    }

    public function setUp()
    {
        // Skip live tests if we don't have credentials
        if (!is_readable($this->getPrivateKey())) {
            $this->markTestSkipped('Skipping Google test without a private key');
        } elseif (strlen(\properties::$google_client_id) < 35) {
            $this->markTestSkipped('Skipping Google test without a valid client ID');
        }
    }

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
        $schema->setInstanceSize('f1-micro')->setTemplateImageId('debian-7-wheezy-v20131120')->addZone(
            new Zone('us-central1-a')
        );

        $r = $im->createInstances(1, $schema);
        var_dump($r);
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

    }

}
 