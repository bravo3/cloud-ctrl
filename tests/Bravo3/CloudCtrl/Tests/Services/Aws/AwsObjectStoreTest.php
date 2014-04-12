<?php
namespace Bravo3\CloudCtrl\Tests\Services\Aws;

use Bravo3\CloudCtrl\Entity\Common\StorageObject;
use Bravo3\CloudCtrl\Services\Aws\AwsObjectStore;
use Bravo3\CloudCtrl\Tests\Base\AwsTestBase;

/**
 * @group aws
 */
class AwsObjectStoreTest extends AwsTestBase
{

    protected $test_data;

    const TEST_KEY = 'test-key';

    public function setUp()
    {
        parent::setUp();
        $this->test_data = 'Test Data! '.rand(1000, 9999);
    }

    /**
     * @group live
     * @medium
     */
    public function testAwsObjectUploadSuccess()
    {
        $service = $this->getService();
        $store   = $service->getObjectStore();

        $this->assertTrue($store instanceof AwsObjectStore);

        $upload_object = StorageObject::fromData(
            $this->properties->getAwsTestBucket(),
            self::TEST_KEY,
            $this->test_data
        );
        $report        = $store->storeObject($upload_object);

        $this->assertTrue($report->getSuccess());
        $this->assertGreaterThanOrEqual(10, strlen($report->getEtag()));
    }

    /**
     * @group live
     * @medium
     */
    public function testAwsObjectDeleteSuccess()
    {
        $service = $this->getService();
        $store   = $service->getObjectStore();
        $this->assertTrue($store instanceof AwsObjectStore);

        $object = new StorageObject($this->properties->getAwsTestBucket(), self::TEST_KEY);

        $report = $store->deleteObject($object);
        $this->assertTrue($report->getSuccess());
    }

    /**
     * @group live
     * @medium
     */
    public function testAwsObjectDeleteInvalidFile()
    {
        $service = $this->getService();
        $store   = $service->getObjectStore();
        $this->assertTrue($store instanceof AwsObjectStore);

        $object = new StorageObject($this->properties->getAwsTestBucket(), 'fake-key-'.rand(10000, 99999));

        $report = $store->deleteObject($object);

        // NB: AWS always returns true for deleting an object that doesn't exist,
        //     there is no way of telling if it did..
        $this->assertTrue($report->getSuccess());
    }

    /**
     * @group live
     * @medium
     */
    public function testAwsObjectUploadBadKeyName()
    {
        $service = $this->getService();
        $store   = $service->getObjectStore();

        $this->assertTrue($store instanceof AwsObjectStore);

        $upload_object = StorageObject::fromData(
            $this->properties->getAwsTestBucket(),
            "\0\t\nInvalid Key!",
            $this->test_data
        );
        $report        = $store->storeObject($upload_object);

        $this->assertFalse($report->getSuccess());
        $this->assertEquals(400, $report->getResultCode());
    }

}
 