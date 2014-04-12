<?php
namespace Bravo3\CloudCtrl\Services\Aws;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Bravo3\CloudCtrl\Entity\Common\StorageObject;
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
            $report->setEtag($transfer->get('ETag'));
            $report->setVersion($transfer->get('Version'));
            $report->setReceipt($transfer->get('RequestId'));

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

        try {
            $transfer = $s3->getObject(
                [
                    'Bucket' => $object->getBucket(),
                    'Key'    => $object->getKey(),
                ]
            );

            var_dump($transfer);

        } catch (S3Exception $e) {

        }

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

            $report->setReceipt($transfer->get('RequestId'));
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
        // TODO: Implement objectExists() method.
    }

    /**
     * @inheritDoc
     */
    public function listObjects($bucket, $prefix)
    {
        // TODO: Implement listObjects() method.
    }


}
 