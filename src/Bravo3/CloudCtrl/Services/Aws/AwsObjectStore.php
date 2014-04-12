<?php
namespace Bravo3\CloudCtrl\Services\Aws;

use Aws\S3\Exception\NoSuchKeyException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Bravo3\CloudCtrl\Entity\Common\StorageObject;
use Bravo3\CloudCtrl\Exceptions\CloudCtrlException;
use Bravo3\CloudCtrl\Exceptions\NotExistsException;
use Bravo3\CloudCtrl\Reports\SuccessReport;
use Bravo3\CloudCtrl\Reports\UploadReport;
use Bravo3\CloudCtrl\Services\Common\ObjectStore;

/**
 * AWS S3 Object Store
 */
class AwsObjectStore extends ObjectStore
{
    use AwsTrait;

    /**
     * @inheritDoc
     */
    public function storeObject(StorageObject $object)
    {
        /** @var S3Client $s3 */
        $s3         = $this->getService('s3');
        $properties = $object->getProperties();

        $stream = null;
        $source = $object->hasCachedData() ? $object->getData() : ($object->getLocalFilename() ? $stream = fopen(
            $object->getLocalFilename(),
            'r'
        ) : null);


        $report = new UploadReport();
        $report->setSuccess(true);

        try {
            $transfer = $s3->upload(
                $object->getBucket(),
                $object->getKey(),
                $source,
                $properties->getAcl(),
                $properties->getOptions()
            );
            $report->setEtag($transfer['ETag']);
            $report->setVersion($transfer['Version']);
            $report->setReceipt($transfer['RequestId']);

        } catch (\Aws\S3\Exception\S3Exception $e) {
            $report->setSuccess(false);
            $report->setResultCode($e->getResponse()->getStatusCode());
            $report->setResultMessage($e->getResponse()->getMessage());
        }

        if ($stream !== null) {
            fclose($stream);
        }

        return $report;
    }

    /**
     * @inheritDoc
     */
    public function retrieveObject(StorageObject $object)
    {
        /** @var S3Client $s3 */
        $s3 = $this->getService('s3');

        $useLocal = $object->getLocalFilename() ? true : false;

        $args = [
            'Bucket' => $object->getBucket(),
            'Key'    => $object->getKey(),
        ];

        if ($useLocal) {
            $args['SaveAs'] = $object->getLocalFilename();
        }

        try {
            $transfer = $s3->getObject($args);

            if (!$useLocal) {
                $object->setData((string)$transfer['Body']);
            }

            $object->getProperties()->setEtag($transfer['ETag']);
            $object->getProperties()->setVersion($transfer['Version']);
            $object->getProperties()->setLastModified($transfer['LastModified']);

        } catch (NoSuchKeyException $e) {
            throw new NotExistsException(
                'The requested object does not exist in bucket "'.$object->getBucket().'"',
                0, $e, $object->getKey());
        } catch (S3Exception $e) {
            throw new CloudCtrlException(
                "An error occurred trying to retrieve the object",
                $e->getResponse()->getStatusCode(), $e);
        }

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function deleteObject(StorageObject $object)
    {
        /** @var S3Client $s3 */
        $s3 = $this->getService('s3');

        $report = new SuccessReport();
        $report->setSuccess(true);

        try {
            $transfer = $s3->deleteObject(
                [
                    'Bucket' => $object->getBucket(),
                    'Key'    => $object->getKey(),
                ]
            );

            $report->setReceipt($transfer['RequestId']);
        } catch (S3Exception $e) {
            $report->setSuccess(false);
            $report->setResultCode($e->getResponse()->getStatusCode());
            $report->setResultMessage($e->getResponse()->getMessage());

        }

        return $report;
    }

    /**
     * @inheritDoc
     */
    public function objectExists(StorageObject $object)
    {
        /** @var S3Client $s3 */
        $s3 = $this->getService('s3');

        $args = [
            'Bucket' => $object->getBucket(),
            'Key'    => $object->getKey(),
        ];

        try {
            $transfer = $s3->headObject($args);

            $object->getProperties()->setEtag($transfer['ETag']);
            $object->getProperties()->setVersion($transfer['Version']);
            $object->getProperties()->setLastModified($transfer['LastModified']);

            return true;

        } catch (NoSuchKeyException $e) {

            return false;

        } catch (S3Exception $e) {

            throw new CloudCtrlException(
                "An error occurred trying to retrieve the object",
                $e->getResponse()->getStatusCode(), $e);

        }

    }

    /**
     * @inheritDoc
     */
    public function listObjects($bucket, $prefix)
    {
        // TODO: Implement listObjects() method.
    }


}
 