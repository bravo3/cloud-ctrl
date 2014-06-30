<?php
namespace Bravo3\CloudCtrl\Reports;

use Bravo3\CloudCtrl\Reports\Traits\SuccessTrait;

class ImageCreateReport
{
    use SuccessTrait;

    protected $image_id;

    /**
     * Set ImageId
     *
     * @param mixed $image_id
     * @return $this
     */
    public function setImageId($image_id)
    {
        $this->image_id = $image_id;
        return $this;
    }

    /**
     * Get ImageId
     *
     * @return mixed
     */
    public function getImageId()
    {
        return $this->image_id;
    }

} 