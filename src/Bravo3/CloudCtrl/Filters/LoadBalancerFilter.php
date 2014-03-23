<?php
namespace Bravo3\CloudCtrl\Filters;

use Bravo3\CloudCtrl\Filters\Traits\IdentityFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\TagFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\ZoneFilterTrait;

/**
 * Load-balancer filter
 */
class LoadBalancerFilter
{
    use TagFilterTrait;
    use IdentityFilterTrait;
    use ZoneFilterTrait;
}
 