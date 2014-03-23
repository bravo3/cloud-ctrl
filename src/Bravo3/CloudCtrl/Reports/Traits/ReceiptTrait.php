<?php
namespace Bravo3\CloudCtrl\Reports\Traits;

/**
 * The result has some sort of receipt string
 */
trait ReceiptTrait
{
    /**
     * @var string
     */
    protected $receipt;

    /**
     * Set Receipt
     *
     * @param string $receipt
     * @return $this
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
        return $this;
    }

    /**
     * Get Receipt
     *
     * @return string
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

}
 