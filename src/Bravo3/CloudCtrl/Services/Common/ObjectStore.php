<?php
namespace Bravo3\CloudCtrl\Services\Common;

use Bravo3\CloudCtrl\Entity\Common\StorageObject;
use Bravo3\CloudCtrl\Exceptions\NotExistsException;
use Bravo3\CloudCtrl\Reports\SuccessReport;
use Bravo3\CloudCtrl\Reports\UploadReport;

/**
 * Remote object storage
 */
abstract class ObjectStore extends CloudServiceAwareComponent
{

    /**
     * Store some data in the remote object store
     *
     * @param StorageObject $object
     * @return UploadReport
     */
    abstract public function storeObject(StorageObject $object);

    /**
     * Retrieve an object from the remote store
     *
     * This will save to a file if a local filename exists, else it will populate the object data.
     *
     * @param StorageObject $object
     * @return StorageObject
     * @throws NotExistsException
     */
    abstract public function retrieveObject(StorageObject $object);

    /**
     * Delete a remote object
     *
     * @param StorageObject $object
     * @return SuccessReport
     */
    abstract public function deleteObject(StorageObject $object);

    /**
     * Check if a remote object exists
     *
     * @param StorageObject $object
     * @return boolean
     */
    abstract public function objectExists(StorageObject $object);

    abstract public function listObjects($bucket, $prefix);

}
 