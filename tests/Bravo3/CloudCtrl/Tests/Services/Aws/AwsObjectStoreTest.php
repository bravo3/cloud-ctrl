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

    protected static $test_data;
    protected static $test_key;

    public static function setUpBeforeClass()
    {
        self::$test_data = 'Test Data! '.rand(1000, 9999);
        self::$test_key  = 'test-key-'.rand(1000, 9999).'.txt';
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
            self::$test_key,
            self::$test_data
        );

        $report = $store->storeObject($upload_object);

        $this->assertTrue($report->getSuccess());
        $this->assertGreaterThanOrEqual(10, strlen($report->getEtag()));
    }

    /**
     * @group   live
     * @medium
     * @depends testAwsObjectUploadSuccess
     */
    public function testAwsObjectObjectExists()
    {
        $service = $this->getService();
        $store   = $service->getObjectStore();
        $this->assertTrue($store instanceof AwsObjectStore);

        $object = new StorageObject($this->properties->getAwsTestBucket(), self::$test_key);
        $exists = $store->objectExists($object);

        $this->assertTrue($exists);
        $this->assertGreaterThanOrEqual(10, strlen($object->getProperties()->getEtag()));

        $fake_object = new StorageObject($this->properties->getAwsTestBucket(), 'fake-key-'.rand(10000, 99999));
        $this->assertFalse($store->objectExists($fake_object));
    }

    /**
     * @group   live
     * @medium
     * @depends testAwsObjectUploadSuccess
     */
    public function testAwsObjectRetrieveSuccess()
    {
        $service = $this->getService();
        $store   = $service->getObjectStore();
        $this->assertTrue($store instanceof AwsObjectStore);

        $object = new StorageObject($this->properties->getAwsTestBucket(), self::$test_key);

        $new_object = $store->retrieveObject($object);
        $this->assertSame($new_object, $object);
        $this->assertTrue($new_object->getProperties()->getLastModified() instanceof \DateTime);
        $this->assertGreaterThanOrEqual(10, strlen($new_object->getProperties()->getEtag()));
        $this->assertEquals($object->getData(), $new_object->getData());
        $this->assertEquals($object->getData(), self::$test_data);
    }

    /**
     * @group live
     * @medium
     * @expectedException \Bravo3\CloudCtrl\Exceptions\NotExistsException
     */
    public function testAwsObjectRetrieveFail()
    {
        $service = $this->getService();
        $store   = $service->getObjectStore();
        $this->assertTrue($store instanceof AwsObjectStore);

        $object = new StorageObject($this->properties->getAwsTestBucket(), 'fake-key-'.rand(10000, 99999));
        $store->retrieveObject($object);
    }

    /**
     * @group   live
     * @medium
     * @depends testAwsObjectUploadSuccess
     */
    public function testAwsObjectDeleteSuccess()
    {
        $service = $this->getService();
        $store   = $service->getObjectStore();
        $this->assertTrue($store instanceof AwsObjectStore);

        $object = new StorageObject($this->properties->getAwsTestBucket(), self::$test_key);

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
        //     there is no way of telling if it did delete an object or not.
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
            self::$test_data
        );

        $report = $store->storeObject($upload_object);

        $this->assertFalse($report->getSuccess());
        $this->assertEquals(400, $report->getResultCode());
    }

}
 