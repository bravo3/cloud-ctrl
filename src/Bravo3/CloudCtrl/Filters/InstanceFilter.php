<?php
namespace Bravo3\CloudCtrl\Filters;

use Bravo3\CloudCtrl\Filters\Traits\IdentityFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\InstanceSizeFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\InstanceTypeFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\TagFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\ZoneFilterTrait;

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
 