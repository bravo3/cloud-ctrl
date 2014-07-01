<?php
namespace Bravo3\CloudCtrl\Filters;

use Bravo3\CloudCtrl\Collections\ImageCollection;
use Bravo3\CloudCtrl\Filters\Traits\IdentityFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\OwnerFilterTrait;
use Bravo3\CloudCtrl\Filters\Traits\TagFilterTrait;
use Bravo3\CloudCtrl\Interfaces\Common\ImageInterface;

/**
 * AbstractImage filter
 */
class ImageFilter
{
    use TagFilterTrait;
    use IdentityFilterTrait;
    use OwnerFilterTrait;

    /**
     * Create an image filter from a collection of images
     *
     * @param ImageCollection $images
     * @return InstanceFilter
     */
    public static function fromImageCollection(ImageCollection $images)
    {
        $filter = new self();

        /** @var ImageInterface $image */
        foreach ($images as $image) {
            $filter->addId($image->getImageId());
        }

        return $filter;
    }
}
