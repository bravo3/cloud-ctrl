<?php
namespace NovaTek\CloudCtrl\Reports;

use NovaTek\CloudCtrl\Entity\Instance;
use NovaTek\CloudCtrl\Reports\Traits\RawTrait;
use NovaTek\CloudCtrl\Reports\Traits\ReceiptTrait;
use NovaTek\CloudCtrl\Reports\Traits\SuccessTrait;

/**
 * Result of a bulk instance operation
 */
class InstanceProvisionReport
{
    use ReceiptTrait;
    use SuccessTrait;
    use RawTrait;

    /**
     * @var Instance[]
     */
    protected $instances = [];

    /**
     * Set Instances
     *
     * @param Instance[] $instances
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
     * @return Instance[]
     */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
     * Add an instance to the result stack
     *
     * @param Instance $instance
     * @return InstanceProvisionReport
     */
    public function addInstance(Instance $instance)
    {
        $this->instances[] = $instance;
        return $this;
    }

}
 