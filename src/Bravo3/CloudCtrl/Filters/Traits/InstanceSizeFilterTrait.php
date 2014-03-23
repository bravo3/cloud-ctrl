<?php
namespace Bravo3\CloudCtrl\Filters\Traits;

/**
 * 
 */
trait InstanceSizeFilterTrait
{

    /**
     * @var string[]
     */
    protected $sizeList = [];

    /**
     * Set SizeList
     *
     * @param \string[] $sizeList
     * @return $this
     */
    public function setSizeList($sizeList)
    {
        $this->sizeList = $sizeList;
        return $this;
    }

    /**
     * Get SizeList
     *
     * @return \string[]
     */
    public function getSizeList()
    {
        return $this->sizeList;
    }

    /**
     * Add an instance size to the list
     *
     * @param $size
     * @return $this
     */
    public function addSize($size)
    {
        $this->sizeList[] = $size;
        return $this;
    }

} 