<?php
namespace NovaTek\CloudCtrl\Filters\Traits;

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
     * @return InstanceSizeFilterTrait
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
     * @return InstanceSizeFilterTrait
     */
    public function addSize($size)
    {
        $this->sizeList[] = $size;
        return $this;
    }

} 