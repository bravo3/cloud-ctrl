<?php
namespace Bravo3\CloudCtrl\Services\Aws;

use Aws\Ec2\Ec2Client;
use Aws\Ec2\Exception\Ec2Exception;
use Bravo3\CloudCtrl\Entity\Aws\AwsInstance;
use Bravo3\CloudCtrl\Enum\Tenancy;
use Bravo3\CloudCtrl\Exceptions\InvalidValueException;
use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Reports\InstanceProvisionReport;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\Common\InstanceManager;

/**
 * Amazon Web Services instance manager for EC2
 */
class AwsInstanceManager extends InstanceManager
{
    use AwsTrait;

    const NO_NAME         = '<no name>';
    const DRY_RUN_STATUS  = 412;
    const DRY_RUN_ERR     = "Request would have succeeded, but DryRun flag is set.";
    const DRY_RUN_RECEIPT = "dry-run-only";

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

    public function describeInstances(InstanceFilter $instances)
    {
        // TODO: Implement describeInstances() method.
    }

    public function setInstanceTags($tags, InstanceFilter $instances)
    {
        // TODO: Implement setInstanceTags() method.
    }


}
 