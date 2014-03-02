<?php
namespace NovaTek\CloudCtrl\Filters;

use NovaTek\CloudCtrl\Filters\Traits\IdentityFilterTrait;
use NovaTek\CloudCtrl\Filters\Traits\TagFilterTrait;
use NovaTek\CloudCtrl\Filters\Traits\ZoneFilterTrait;

/**
 * Load-balancer filter
 */
class LoadBalancerFilter
{
    use TagFilterTrait;
    use IdentityFilterTrait;
    use ZoneFilterTrait;
}
 