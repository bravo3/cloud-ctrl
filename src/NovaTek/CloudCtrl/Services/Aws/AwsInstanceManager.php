<?php
namespace NovaTek\CloudCtrl\Services\Aws;

use Aws\Ec2\Ec2Client;
use Aws\Ec2\Exception\Ec2Exception;
use NovaTek\CloudCtrl\Enum\Tenancy;
use NovaTek\CloudCtrl\Exceptions\InvalidValueException;
use NovaTek\CloudCtrl\Filters\InstanceFilter;
use NovaTek\CloudCtrl\Reports\InstanceProvisionReport;
use NovaTek\CloudCtrl\Schema\InstanceSchema;
use NovaTek\CloudCtrl\Services\Common\InstanceManager;

/**
 * Amazon Web Services instance manager for EC2
 */
class AwsInstanceManager extends InstanceManager
{
    use AwsTrait;

    const DRY_RUN_ERR     = "Request would have succeeded, but DryRun flag is set.";
    const DRY_RUN_RECEIPT = "dry-run-only";

    /**
     * Create some peeps
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

        // Placement
        $placement = ['Tenancy' => $tenancy];
        if (count($schema->getZones())) {
            // TODO: we want to evenly spread across zones - AWS doesn't do this easily
            // FIXME: fixed to first option for now
            $placement['AvailabilityZone'] = $schema->getZones()[0];
        }

        // API params
        $params = [
            'DryRun'           => $this->getDryMode(),
            'ImageId'          => $schema->getTemplateImageId(),
            'MinCount'         => $count,
            'MaxCount'         => $count,
            'KeyName'          => $schema->getKeyName(),
            'SecurityGroupIds' => $schema->getSecurityGroups(),
            //'UserData'         => '',
            'InstanceType'     => $schema->getInstanceSize(),
            'Placement'        => $placement,
        ];


        $report = new InstanceProvisionReport();

        try {
            // Run the request
            $r = $ec2->runInstances($params);

            // Gather the success report
            $report->setRaw($r);
            $report->setSuccess(true);
            $report->setReceipt($r->get('ReservationId'));

        } catch (Ec2Exception $e) {
            // Gather the error report
            $report->setResultCode($e->getResponse()->getStatusCode());
            $report->setResultMessage($e->getMessage());
            $report->setParentException($e);

            if ($e->getResponse()->getStatusCode() == 412 && $e->getMessage() == self::DRY_RUN_ERR) {
                // Dry-run success
                $report->setSuccess(true);
                $report->setReceipt(self::DRY_RUN_RECEIPT);
            } else {
                // API failure
                $report->setSuccess(false);
            }

        } catch (\Exception $e) {
            // Unknown failure
            $report->setSuccess(false);
            $report->setResultCode($e->getCode());
            $report->setResultMessage($e->getMessage());
            $report->setParentException($e);
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

    public function describeInstances(InstanceFilter $instances)
    {
        // TODO: Implement describeInstances() method.
    }

    public function setInstanceTags($tags, InstanceFilter $instances)
    {
        // TODO: Implement setInstanceTags() method.
    }


}
 