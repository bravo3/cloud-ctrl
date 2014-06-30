<?php
namespace Bravo3\CloudCtrl\Reports\Traits;

use Bravo3\CloudCtrl\Collections\ImageCollection;
use Bravo3\CloudCtrl\Interfaces\Common\ImageInterface;

/**
 * Contains a list of images
 */
trait ImageListTrait
{
    /**
     * @var ImageInterface[]
     */
    protected $images = [];

    /**
     * Set images as an array
     *
     * @param ImageCollection|ImageInterface[] $images
     * @return $this
     */
    public function setImages($images)
    {
        $this->images = ($images instanceof ImageCollection) ? $images->toArray() : $images;
        return $this;
    }

    /**
     * Get a collection of all images
     *
     * @return ImageCollection
     */
    public function getImages()
    {
        return new ImageCollection($this->images);
    }

    /**
     * Add an instance to the result stack
     *
     * @param ImageInterface $instance
     * @return $this
     */
    public function addInstance(ImageInterface $instance)
    {
        $this->images[] = $instance;
        return $this;
    }
}
