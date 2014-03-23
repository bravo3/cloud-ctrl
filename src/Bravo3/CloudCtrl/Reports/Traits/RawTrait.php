<?php
namespace Bravo3\CloudCtrl\Reports\Traits;

/**
 * Response contains a raw result
 */
trait RawTrait
{
    /**
     * @var mixed
     */
    protected $raw;

    /**
     * Set the raw result
     *
     * @param mixed $raw
     * @return $this
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
        return $this;
    }

    /**
     * Get the raw result
     *
     * @return mixed
     */
    public function getRaw()
    {
        return $this->raw;
    }

} 