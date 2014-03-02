<?php
namespace NovaTek\CloudCtrl\Filters;

use NovaTek\CloudCtrl\Filters\Traits\IdentityFilterTrait;
use NovaTek\CloudCtrl\Filters\Traits\InstanceSizeFilterTrait;
use NovaTek\CloudCtrl\Filters\Traits\InstanceTypeFilterTrait;
use NovaTek\CloudCtrl\Filters\Traits\TagFilterTrait;
use NovaTek\CloudCtrl\Filters\Traits\ZoneFilterTrait;

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
}
 