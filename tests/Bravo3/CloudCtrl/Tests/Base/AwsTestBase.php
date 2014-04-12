<?php
namespace Bravo3\CloudCtrl\Tests\Base;

use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Services\Aws\AwsService;
use Bravo3\CloudCtrl\Services\CloudService;
use Bravo3\CloudCtrl\Tests\Resources\TestProperties;

class AwsTestBase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var TestProperties
     */
    protected $properties;

    public function setUp()
    {
        $this->properties = \properties::getInstance();
        if ($this->properties->getAwsCredentials() === null) {
            $this->markTestSkipped('Skipping AWS test without a valid credentials');
        }
    }

    /**
     * @return AwsService
     */
    protected function getService($credentials = null)
    {
        if ($credentials === null) {
            $credentials = $this->properties->getAwsCredentials();
        }

        $service = CloudService::createCloudService(Provider::AWS, $credentials);
        $this->assertTrue($service instanceof AwsService);
        $service->setProxy($this->properties->getProxy());

        return $service;
    }

}