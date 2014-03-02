<?php
namespace NovaTek\CloudCtrl\Reports\Traits;

/**
 * Was the action successful or not
 */
trait SuccessTrait
{

    /**
     * @var bool
     */
    protected $success = false;

    /**
     * @var int
     */
    protected $result_code = 0;

    /**
     * @var string
     */
    protected $result_message = null;

    /**
     * @var \Exception
     */
    protected $parent_exception = null;

    /**
     * Define if the action was successful
     *
     * @param boolean $success
     * @return $this
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }

    /**
     * Check if the action was successful
     *
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Set the result code
     *
     * @param int $result_code
     * @return $this
     */
    public function setResultCode($result_code)
    {
        $this->result_code = $result_code;
        return $this;
    }

    /**
     * Get the result code
     *
     * @return int
     */
    public function getResultCode()
    {
        return $this->result_code;
    }

    /**
     * Set the result message
     *
     * @param string $result_message
     * @return $this
     */
    public function setResultMessage($result_message)
    {
        $this->result_message = $result_message;
        return $this;
    }

    /**
     * Get the result message
     *
     * @return string
     */
    public function getResultMessage()
    {
        return $this->result_message;
    }

    /**
     * Set ParentException
     *
     * @param \Exception $parent_exception
     * @return $this
     */
    public function setParentException(\Exception $parent_exception)
    {
        $this->parent_exception = $parent_exception;
        return $this;
    }

    /**
     * Get ParentException
     *
     * @return \Exception
     */
    public function getParentException()
    {
        return $this->parent_exception;
    }

} 