<?php
namespace Bravo3\CloudCtrl\Reports;

use Bravo3\CloudCtrl\Reports\Traits\EtagTrait;
use Bravo3\CloudCtrl\Reports\Traits\ReceiptTrait;
use Bravo3\CloudCtrl\Reports\Traits\SuccessTrait;
use Bravo3\CloudCtrl\Reports\Traits\VersionTrait;

/**
 * Object upload report
 */
class UploadReport
{
    use SuccessTrait;
    use ReceiptTrait;
    use VersionTrait;
    use EtagTrait;

}
 