<?php
namespace Bravo3\CloudCtrl\Reports;

use Bravo3\CloudCtrl\Interfaces\Instance\InstanceInterface;
use Bravo3\CloudCtrl\Reports\Traits\RawTrait;
use Bravo3\CloudCtrl\Reports\Traits\ReceiptTrait;
use Bravo3\CloudCtrl\Reports\Traits\SuccessTrait;

/**
 * Result of a bulk instance operation
 */
class InstanceProvisionReport
{
    use ReceiptTrait;
    use SuccessTrait;
    use RawTrait;

    /**
     * @var InstanceInterface[]
     */
    protected $instances = [];

    /**
     * Set Instances
     *
     * @param InstanceInterface[] $instances
     * @return InstanceProvisionReport
     */
    public function setInstances($instances)
    {
        $this->instances = $instances;
        return $this;
    }

    /**
     * Get Instances
     *
     * @return InstanceInterface[]
     */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
     * Add an instance to the result stack
     *
     * @param InstanceInterface $instance
     * @return InstanceProvisionReport
     */
    public function addInstance(InstanceInterface $instance)
    {
        $this->instances[] = $instance;
        return $this;
    }

}
 