<?php
namespace Bravo3\CloudCtrl\Exceptions;

/**
 * Object/item does not exist
 */
class NotExistsException extends CloudCtrlException
{
    protected $object;

    function __construct(
        $messsage = 'The requested object does not exist',
        $code = 0,
        $exception = null,
        $object = null
    ) {
        parent::__construct($messsage, $code, $exception);
        $this->object = $object;
    }

    /**
     * Get the requested object name that is missing
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }


}
 