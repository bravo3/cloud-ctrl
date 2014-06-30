<?php
namespace Bravo3\CloudCtrl\Reports;

use Bravo3\CloudCtrl\Reports\Traits\InstanceListTrait;
use Bravo3\CloudCtrl\Reports\Traits\RawTrait;
use Bravo3\CloudCtrl\Reports\Traits\ReceiptTrait;
use Bravo3\CloudCtrl\Reports\Traits\SuccessTrait;

/**
 * Result of a bulk instance operation
 */
class InstanceListReport
{
    use SuccessTrait;
    use RawTrait;
    use InstanceListTrait;

}
 