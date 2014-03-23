<?php
namespace Bravo3\CloudCtrl\Filters\Traits;

use Bravo3\CloudCtrl\Enum\InstanceType;
use Bravo3\CloudCtrl\Exceptions\InvalidValueException;

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
     * @return $this
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
     * @return $this
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