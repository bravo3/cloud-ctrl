<?php
namespace Bravo3\CloudCtrl\Tests\Base;

use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Services\CloudService;
use Bravo3\CloudCtrl\Services\Google\GoogleService;
use Bravo3\CloudCtrl\Tests\Resources\TestProperties;

class GoogleTestBase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var TestProperties
     */
    protected $properties;

    public function setUp()
    {
        $this->properties = \properties::getInstance();
        if ($this->properties->getAwsCredentials() === null) {
            $this->markTestSkipped('Skipping Google test without a valid credentials');
        }
    }

    /**
     * @return GoogleService
     */
    protected function getService($credentials = null)
    {
        if ($credentials === null) {
            $credentials = $this->properties->getGoogleCredentials();
        }

        $service = CloudService::createCloudService(Provider::GOOGLE, $credentials);
        $this->assertTrue($service instanceof GoogleService);
        $service->setProxy($this->properties->getProxy());

        return $service;
    }

}