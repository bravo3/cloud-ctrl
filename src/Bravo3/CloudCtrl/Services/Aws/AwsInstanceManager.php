<?php
namespace Bravo3\CloudCtrl\Services\Aws;

use Aws\Ec2\Ec2Client;
use Aws\Ec2\Exception\Ec2Exception;
use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Entity\Aws\AwsImage;
use Bravo3\CloudCtrl\Entity\Aws\AwsInstance;
use Bravo3\CloudCtrl\Entity\Common\Zone;
use Bravo3\CloudCtrl\Enum\Aws\VolumeType;
use Bravo3\CloudCtrl\Enum\Tenancy;
use Bravo3\CloudCtrl\Exceptions\InvalidValueException;
use Bravo3\CloudCtrl\Exceptions\SchemaException;
use Bravo3\CloudCtrl\Filters\IdFilter;
use Bravo3\CloudCtrl\Filters\ImageFilter;
use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Reports\ImageCreateReport;
use Bravo3\CloudCtrl\Reports\ImageListReport;
use Bravo3\CloudCtrl\Reports\InstanceListReport;
use Bravo3\CloudCtrl\Reports\InstanceProvisionReport;
use Bravo3\CloudCtrl\Reports\SuccessReport;
use Bravo3\CloudCtrl\Schema\ImageSchema;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\CloudService;
use Bravo3\CloudCtrl\Services\Common\InstanceManager;
use Guzzle\Service\Resource\Model;

/**
 * Amazon Web Services instance manager for EC2
 */
class AwsInstanceManager extends InstanceManager
{
    const MAX_RESULTS     = 1000;
    const NO_NAME         = '<no name>';
    const DRY_RUN_STATUS  = 412;
    const DRY_RUN_ERR     = "Request would have succeeded, but DryRun flag is set.";
    const DRY_RUN_RECEIPT = "dry-run-only";
    const DEFAULT_IOPS    = 300;

    use AwsTrait;

    protected $genericSuccessFn;
    protected $genericFailFn;

    function __construct(CloudService $cloud_service)
    {
        parent::__construct($cloud_service);

        // Create a generic success/fail function for calls that should just return a SuccessReport
        // These functions are used by #ec2ApiCall() to streamline the API call process
        $this->genericSuccessFn = function (Model $m) {
            $report = new SuccessReport();
            $report->setSuccess(true);
            return $report;
        };
        $this->genericFailFn    = function (Ec2Exception $e) {
            $report = new SuccessReport();
            $report->setSuccess(false);
            $report->setResultCode($e->getResponse()->getStatusCode());
            $report->setResultMessage($e->getResponse()->getMessage());
            return $report;
        };
    }

    /**
     * Create some instances
     *
     * @param int            $count
     * @param InstanceSchema $schema
     * @return InstanceProvisionReport
     * @throws InvalidValueException
     */
    public function createInstances($count, InstanceSchema $schema)
    {
        /** @var $ec2 Ec2Client */
        $ec2 = $this->getService('ec2');

        // VPC tenancy
        switch ($schema->getTenancy()) {
            default:
                throw new InvalidValueException('Unsupported tenancy: '.$schema->getTenancy());
            case Tenancy::VPC:
                $tenancy = 'default';
                break;
            case Tenancy::DEDICATED:
                $tenancy = 'dedicated';
                break;
        }

        $report = new InstanceProvisionReport();

        $zones          = $schema->getZones();
        $zone_count     = count($zones);
        $single_request = $zone_count == 1;

        // If we have multiple zones, we need to do this 1 at a time to break up the requests
        // If not, AWS can spawn them all at once
        for ($i = 0; $i < ($single_request ? 1 : $count); $i++) {
            // Placement
            $placement = ['Tenancy' => $tenancy];
            if ($zone_count) {
                $zone                          = $zones[$i % $zone_count];
                $placement['AvailabilityZone'] = $zone->getZoneName();
            } else {
                $zone = null;
            }

            // API params
            $params = [
                'DryRun'           => $this->getDryMode(),
                'ImageId'          => $schema->getTemplateImageId(),
                'MinCount'         => $single_request ? $count : 1,
                'MaxCount'         => $single_request ? $count : 1,
                'KeyName'          => $schema->getKeyName(),
                'SecurityGroupIds' => $schema->getFirewalls(),
                //'UserData'         => '',
                'InstanceType'     => $schema->getInstanceSize(),
                'Placement'        => $placement,
            ];

            try {
                // Run the request
                $r = $ec2->runInstances($params);

                // Gather the success report
                $report->setRaw($r);
                $report->setSuccess(true);
                $report->setReceipt($r->get('ReservationId'));

                $instances = AwsInstance::fromApiResult($r);
                foreach ($instances as $instance) {
                    $this->logCreateInstance($i, $instance, self::NO_NAME);
                    $report->addInstance($instance);
                }

            } catch (Ec2Exception $e) {
                // API failure
                $report->setSuccess(false);
                $report->setResultCode($e->getResponse()->getStatusCode());
                $report->setResultMessage($e->getMessage());
                $report->setParentException($e);

            } catch (\Exception $e) {
                // Unknown failure
                $report->setSuccess(false);
                $report->setResultCode($e->getCode());
                $report->setResultMessage($e->getMessage());
                $report->setParentException($e);
            }
        }

        // Tag instances, this can only be done post-launch
        if ($report->getSuccess() && count($schema->getTags())) {
            $this->setInstanceTags($schema->getTags(), InstanceFilter::fromInstanceCollection($report->getInstances()));
        }

        return $report;
    }

    /**
     * Start a set of stopped instances
     *
     * @param IdFilter $instances
     * @return SuccessReport
     */
    public function startInstances(IdFilter $instances)
    {
        // Make the API call
        return $this->ec2ApiCall(
            'startInstances',
            [
                'DryRun'      => $this->getDryMode(),
                'InstanceIds' => $instances->getIdList(),
            ],
            $this->genericSuccessFn,
            $this->genericFailFn
        );
    }

    /**
     * Stop a set of running instances
     *
     * @param IdFilter $instances
     * @param bool     $force
     * @return SuccessReport
     */
    public function stopInstances(IdFilter $instances, $force = false)
    {
        // Make the API call
        return $this->ec2ApiCall(
            'stopInstances',
            [
                'DryRun'      => $this->getDryMode(),
                'InstanceIds' => $instances->getIdList(),
                'Force'       => $force,
            ],
            $this->genericSuccessFn,
            $this->genericFailFn
        );
    }

    /**
     * Terminate a set of instances
     *
     * @param IdFilter $instances
     * @return SuccessReport
     */
    public function terminateInstances(IdFilter $instances)
    {
        // Make the API call
        return $this->ec2ApiCall(
            'terminateInstances',
            [
                'DryRun'      => $this->getDryMode(),
                'InstanceIds' => $instances->getIdList(),
            ],
            $this->genericSuccessFn,
            $this->genericFailFn
        );
    }

    /**
     * Restart a set of instances
     *
     * @param IdFilter $instances
     * @return SuccessReport
     */
    public function restartInstances(IdFilter $instances)
    {
        // Make the API call
        return $this->ec2ApiCall(
            'rebootInstances',
            [
                'DryRun'      => $this->getDryMode(),
                'InstanceIds' => $instances->getIdList(),
            ],
            $this->genericSuccessFn,
            $this->genericFailFn
        );
    }

    /**
     * Get a list of AWS instances
     *
     * @param InstanceFilter $instances
     * @return InstanceListReport
     */
    public function describeInstances(InstanceFilter $instances)
    {
        /** @var $ec2 Ec2Client */
        $ec2    = $this->getService('ec2');
        $report = new InstanceListReport();

        $filters = [];

        // Tags
        foreach ($instances->getTags() as $key => $value) {
            $filters[] = [
                'Name'   => 'tag:'.$key,
                'Values' => (array)$value
            ];
        }

        // Instance size (aka 'type')
        if ($values = $instances->getSizeList()) {
            $filters[] = [
                'Name'   => 'instance-type',
                'Values' => $values,
            ];
        }

        // Instance type (eg on-demand, spot, reserved)
        // TODO: find out what the damn value should be, see issue #2
        //if ($values = $instances->getTypeList()) {
        //    $filters[] = [
        //        'Name' => 'instance-lifecycle',
        //        'Values' => null,
        //    ];
        //}

        if ($values = $instances->getZoneList()) {
            $filter_values = [];
            foreach ($values as $zone) {
                /** @var Zone $zone */
                $filter_values[] = $zone->getZoneName();
            }

            $filters[] = [
                'Name'   => 'availability-zone',
                'Values' => $filter_values,
            ];
        }

        $token      = null;
        $collection = new InstanceCollection();
        do {
            $result = $ec2->describeInstances(
                [
                    'DryRun'      => $this->getDryMode(),
                    'InstanceIds' => $instances->getIdList(),
                    'Filters'     => $filters,
                    'NextToken'   => $token,
                ]
            );

            $instances = AwsInstance::fromApiResult($result);
            $collection->addCollection($instances);

        } while ($token);

        $report->setInstances($collection);
        $report->setSuccess(true);

        return $report;
    }

    /**
     * Set instance tags
     *
     * @param array          $tags Associative array of tags
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    public function setInstanceTags(array $tags, InstanceFilter $instances)
    {
        $tags = [];
        foreach ($tags as $key => $value) {
            $tags[] = ['Key' => $key, 'Value' => $value];
        }

        // Make the API call
        $this->ec2ApiCall(
            'createTags',
            [
                'DryRun'    => $this->getDryMode(),
                'Resources' => $instances->getIdList(),
                'Tags'      => $tags
            ],
            $this->genericSuccessFn,
            $this->genericFailFn
        );
    }


    /**
     * Start the process of saving a machine image
     *
     * @param string      $instance_id
     * @param ImageSchema $image_schema
     * @return ImageCreateReport
     * @throws SchemaException
     */
    public function createImage($instance_id, ImageSchema $image_schema)
    {
        $volumes = [];
        foreach ($image_schema->getStorageDevices() as $volume) {
            if ($volume->getIops()) {
                $ebs['Iops'] = $volume->getIops();
            } elseif ($volume->getVolumeType() == VolumeType::PROVISIONED_IO) {
                throw new SchemaException("Provisioned IOPS devices require an IOPS value");
            }

            $volume_schema = [
                'VirtualName' => $volume->getVirtualName(),
                'DeviceName'  => $volume->getDeviceName(),
                //'NoDevice' => 'string',
            ];

            if ($volume->getVolumeType() != VolumeType::EPHEMERAL) {
                $volume_schema['Ebs'] = [
                    'DeleteOnTermination' => $volume->getDeleteOnTermination(),
                    'VolumeType'          => $volume->getVolumeType() ? : VolumeType::STANDARD,
                    'Encrypted'           => $volume->getEncrypted(),
                    'VolumeSize'          => $volume->getVolumeSizeGb(),
                    'SnapshotId'          => $volume->getSnapshotId(),
                ];
            }

            $volumes[] = $volume_schema;
        }

        // Make the API call
        $report = $this->ec2ApiCall(
            'createImage',
            [
                'DryRun'              => $this->getDryMode(),
                'InstanceId'          => $instance_id,
                'Name'                => $image_schema->getImageName(),
                'Description'         => $image_schema->getImageDescription(),
                'NoReboot'            => !$image_schema->getAllowReboot(),
                'BlockDeviceMappings' => $volumes,
            ],
            function (Model $r) {
                $report = new ImageCreateReport();
                $report->setSuccess(true);
                $report->setImageId($r->get('ImageId'));
                return $report;
            },
            function (Ec2Exception $e) {
                $report = new ImageCreateReport();
                $report->setSuccess(false);
                $report->setResultCode($e->getResponse()->getStatusCode());
                $report->setResultMessage($e->getResponse()->getMessage());
                return $report;
            }
        );

        return $report;
    }


    /**
     * Deregister a machine image allowing for the provider to delete when appropriate
     *
     * @param string $image_id
     * @return SuccessReport
     */
    public function deregisterImage($image_id)
    {
        // Make the API call
        return $this->ec2ApiCall(
            'deregisterImage',
            [
                'DryRun'  => $this->getDryMode(),
                'ImageId' => $image_id
            ],
            $this->genericSuccessFn,
            $this->genericFailFn
        );
    }

    /**
     * Deregister a machine image allowing for the provider to delete when appropriate
     *
     * @param ImageFilter $images
     * @return ImageListReport
     */
    public function describeImages(ImageFilter $images)
    {
        $filters = [];

        // Tags
        foreach ($images->getTags() as $key => $value) {
            $filters[] = [
                'Name'   => 'tag:'.$key,
                'Values' => (array)$value
            ];
        }

        // Make the API call
        $report = $this->ec2ApiCall(
            'describeImages',
            [
                'DryRun'   => $this->getDryMode(),
                'ImageIds' => $images->getIdList(),
                'Owners'   => $images->getOwners(),
                'Filters'  => $filters,
            ],
            function (Model $r) {
                $report = new ImageListReport();
                $report->setSuccess(true);
                $report->setImages(AwsImage::fromApiResult($r));
                return $report;
            },
            function (Ec2Exception $e) {
                $report = new ImageListReport();
                $report->setSuccess(false);
                $report->setResultCode($e->getResponse()->getStatusCode());
                $report->setResultMessage($e->getResponse()->getMessage());
                return $report;
            }
        );

        return $report;
    }

    /**
     * Make an EC2 API call, catching normal error responses
     *
     * The return value of this function will be the return value of the success/fail closure provided.
     *
     * @param string   $fn
     * @param array    $params
     * @param \Closure $success
     * @param \Closure $fail
     * @return mixed
     */
    protected function ec2ApiCall($fn, array $params, \Closure $success, \Closure $fail)
    {
        /** @var $ec2 Ec2Client */
        $ec2 = $this->getService('ec2');

        try {
            return $success($ec2->$fn($params));
        } catch (Ec2Exception $e) {
            return $fail($e);
        }
    }


}
 