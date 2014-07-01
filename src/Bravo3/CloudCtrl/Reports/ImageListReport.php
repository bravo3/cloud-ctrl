<?php
namespace Bravo3\CloudCtrl\Reports;

use Bravo3\CloudCtrl\Reports\Traits\ImageListTrait;
use Bravo3\CloudCtrl\Reports\Traits\RawTrait;
use Bravo3\CloudCtrl\Reports\Traits\ReceiptTrait;
use Bravo3\CloudCtrl\Reports\Traits\SuccessTrait;

/**
 * Result of a bulk image operation
 */
class ImageListReport
{
    use SuccessTrait;
    use RawTrait;
    use ImageListTrait;

}
 