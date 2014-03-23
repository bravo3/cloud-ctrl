<?php
namespace Bravo3\CloudCtrl\Exceptions;

class UnexpectedResultException extends CloudCtrlException
{
    protected $result;

    public function __construct($msg = 'Unexpected result', $code = null, $result = null) {
        parent::__construct($msg, $code);
        $this->result = $result;
    }

    /**
     * Get the actual result
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

}
 