<?php
namespace Bravo3\CloudCtrl\Services\Aws;

use Aws\Ec2\Ec2Client;
use Aws\Ec2\Exception\Ec2Exception;
use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Entity\Aws\AwsInstance;
use Bravo3\CloudCtrl\Entity\Common\Zone;
use Bravo3\CloudCtrl\Enum\Tenancy;
use Bravo3\CloudCtrl\Exceptions\InvalidValueException;
use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Reports\InstanceListReport;
use Bravo3\CloudCtrl\Reports\InstanceProvisionReport;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\Common\InstanceManager;

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

    use AwsTrait;

    /**
     * Create some peeps
     *
     * TODO: this is getting a bit chunky - break down?
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

    public function startInstances(InstanceFilter $instances)
    {
        // TODO: Implement startInstances() method.
    }

    public function stopInstances(InstanceFilter $instances)
    {
        // TODO: Implement stopInstances() method.
    }

    public function terminateInstances(InstanceFilter $instances)
    {
        // TODO: Implement terminateInstances() method.
    }

    public function restartInstances(InstanceFilter $instances)
    {
        // TODO: Implement restartInstances() method.
    }

    /**
     * Get a list of AWS instances
     *
     * @param InstanceFilter $instances
     * @return \Bravo3\CloudCtrl\Reports\InstanceListReport
     */
    public function describeInstances(InstanceFilter $instances)
    {
        /** @var $ec2 Ec2Client */
        $ec2 = $this->getService('ec2');
        $report  = new InstanceListReport();

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
     */
    public function setInstanceTags($tags, InstanceFilter $instances)
    {
        /** @var $ec2 Ec2Client */
        $ec2 = $this->getService('ec2');

        $tags = [];
        foreach ($tags as $key => $value) {
            $tags[] = ['Key' => $key, 'Value' => $value];
        }

        $ec2->createTags(
            [
                'DryRun'    => $this->getDryMode(),
                'Resources' => $instances->getIdList(),
                'Tags'      => $tags
            ]
        );
    }


}
 