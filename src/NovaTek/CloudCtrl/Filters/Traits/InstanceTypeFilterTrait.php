<?php
namespace NovaTek\CloudCtrl\Filters\Traits;

use NovaTek\CloudCtrl\Enum\InstanceType;
use NovaTek\CloudCtrl\Exceptions\InvalidValueException;

/**
 * Filter by instance type (eg on-demand, spot, reserved)
 */
trait InstanceTypeFilterTrait
{

    /**
     * @var string[]
     */
    protected $typeList = [];

    /**
     * Set TypeList
     *
     * @param \string[] $typeList
     * @return InstanceTypeFilterTrait
     */
    public function setTypeList($typeList)
    {
        $this->typeList = $typeList;
        return $this;
    }

    /**
     * Get TypeList
     *
     * @return \string[]
     */
    public function getTypeList()
    {
        return $this->typeList;
    }

    /**
     * Add an instance type to the list
     *
     * @param $type
     * @return InstanceTypeFilterTrait
     */
    public function addType($type)
    {
        if (!in_array($type, InstanceType::getValidInstanceTypes())) {
            throw new InvalidValueException();
        }

        $this->typeList[] = $type;
        return $this;
    }


} 