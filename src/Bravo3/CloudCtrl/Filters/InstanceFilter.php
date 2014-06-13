<?php
namespace Bravo3\CloudCtrl\Filters;

use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Filters\Traits\IdentityFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\InstanceSizeFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\InstanceTypeFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\TagFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\ZoneFilterTrait;
use Bravo3\CloudCtrl\Interfaces\Instance\InstanceInterface;

/**
 * Instance filter
 */
class InstanceFilter
{
    use TagFilterTrait;
    use IdentityFilterTrait;
    use ZoneFilterTrait;
    use InstanceSizeFilterTrait;
    use InstanceTypeFilterTrait;

    /**
     * Create an instance filter from a collection of instances
     *
     * @param InstanceCollection $instances
     * @return InstanceFilter
     */
    public static function fromInstanceCollection(InstanceCollection $instances)
    {
        $filter = new self();

        /** @var InstanceInterface $instance */
        foreach ($instances as $instance) {
            $filter->addId($instance->getInstanceId());
        }

        return $filter;
    }
}
 